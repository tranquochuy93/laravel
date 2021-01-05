### validation
- 1) return default Exception (có thể dạng HTTP Response hoặc JSON nếu request trước đó là ajax)
   - Nếu một field không không thỏa mãn yêu cầu sẽ sinh ra Exception
```php
public function store(Request $request)
{
    $validatedData = $request->validate([
        'username' => 'required',
        'email' => 'required',
        'password' => 'required',
        'password_confirmation' => 'required',
    ]);
}
```
- 2) Custom validation
```php
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'bail|required|alpha|min:6|max:10',
        'email' => 'bail|required|email',
        'password' => 'bail|required|min:8',
        'password_confirmation' => 'bail|required|same:password',
    ]);

    if ($validator->fails()) {
        // Do something
    }
}
```
