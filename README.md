
#### Unicode and UTF-8
- Các kí tự latin được biểu diễn trong bảng mã asscii chỉ cần dùng 1 byte: 0-255
- Các kí tự châu Á cần nhiều byte hơn => UTF biểu diễn kí tự dùng 2 bytes: 0-65
```js
Binary format of bytes in sequence
1st Byte    2nd Byte    3rd Byte    4th Byte    Number of Free Bits   Maximum Expressible Unicode Value
0xxxxxxx                                                7             007F hex (127)
110xxxxx    10xxxxxx                                (5+6)=11          07FF hex (2047)
1110xxxx    10xxxxxx    10xxxxxx                  (4+6+6)=16          FFFF hex (65535)
11110xxx    10xxxxxx    10xxxxxx    10xxxxxx    (3+6+6+6)=21          10FFFF hex (1,114,111)

```
- Đối với tiếng Trung, biểu diễn dưới hàng 3
```js
Header  Place holder    Fill in our Binary   Result         
1110    xxxx            0110                 11100110
10      xxxxxx          110001               10110001
10      xxxxxx          001001               10001001

Viết ra kết quả trong một dòng:

11100110 10110001 10001001
```
- Nguyên tắc: Chọn hàng tương ứng để biểu diễn kí  tự, giữ nguyên header và thay thế xxxx bằng mã hex tương ứng
- Ví dụ
```js
A chinese character:      汉
it's unicode value:       U+6C49
convert 6C49 to binary:   01101100 01001001
embed 6C49 as UTF-8:      11100110 10110001 10001001
giải thích:               1110: header, 0110: 6,  10: header, 1100: C, 01: 4, 10 header, 00: 2 byte sau của mã 4 phía trươc, 1001: 9

```
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
