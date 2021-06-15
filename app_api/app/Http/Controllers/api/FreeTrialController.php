<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\FreeTrial;
use Carbon\Carbon;

class FreeTrialController extends Controller
{

    /**
     * create api
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'device_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 401);
        }

        $deviceId = $request->input('device_id');
        $freeTrial = FreeTrial::where('device_id', $deviceId)->first();
        $responseStatus = 1; // 1.NO_FREE_TIME_TRIAL

        if (!empty($freeTrial)) {
            if ($freeTrial['has_in_app']) {
                $responseStatus = 2; // 2.USER_IN_APP
            } else {
                $expiredTime = strtotime($freeTrial['time_free_trial'] . ' + 4 days');
                $currentTime = time();
                // 3.HAVE_FREE_TIME_TRIAL, 4.FREE_TIME_HAS_ENDED
                $responseStatus = $expiredTime < $currentTime ? 4 : 3;
            }

            return response()->json(
                [
                    'success' => array(
                        'status' => $responseStatus,
                    )
                ],
                200
            );
        }

        $freeTrial = new FreeTrial;
        $freeTrial->device_id = $deviceId;
        $freeTrial->time_free_trial = Carbon::now();
        $freeTrial->has_in_app = FALSE;
        $freeTrial->save();

        return response()->json(
            [
                'success' => array(
                    'status' => $responseStatus,
                )
            ],
            200
        );
    }

    /**
     * update api
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'device_id' => 'required',
                'has_in_app' => 'required|boolean',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 401);
        }

        
        $deviceId = $request->input('device_id');
        $hasInApp = $request->input('has_in_app');
        $freeTrial = FreeTrial::where('device_id', $deviceId)->first();

        if (empty($freeTrial)) {
            return response()->json(
                [
                    'error' => 'device_id is not existed'
                ],
                404
            );
        }

        $freeTrial->has_in_app = $hasInApp;
        $freeTrial->save();

        return response()->json(
            [
                'success' => array(
                    'device_id' => $deviceId,
                    'hasInApp'  => $hasInApp,
                )
            ],
            200
        );
    }
}
