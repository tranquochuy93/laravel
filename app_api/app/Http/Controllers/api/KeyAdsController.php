<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\KeyAds;

class KeyAdsController extends Controller
{
    /**
     * Detail api.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'app_name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 401);
        }

        
        $appName = $request->input('app_name');
        $keyAds = KeyAds::where('app_name', $appName)->first();

        if (empty($keyAds)) {
            return response()->json(
                [
                    'error' => 'app_name is not existed'
                ],
                404
            );
        }

        return response()->json(
            [
                'success' => array(
                    'banner_id' => $keyAds['banner_id'],
                    'native_id' => $keyAds['native_id'],
                    'full_id'   => $keyAds['full_id'],
                    'app_id'    => $keyAds['app_id'],
                )
            ],
            200
        );
    }
}
