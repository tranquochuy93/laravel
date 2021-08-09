#### Interview
1) Khi CK 10$ vào database cùng lúc thì xử lý ntn
=============
1) Lock trong SQL?
2) store engine trong SQL?
- InnoDB: bảo vệ tính toàn vẹn của dữ liệu, row level blocking
+ InnoDB: transaction-safe
     lưu trữ dữ liệu người dùng trong các clustered indexes, việc tìm kiếm theo primary hiệu suất cao
-  thay dổi cấu trúc table phải đánh index lại từ đầu

- MyISAM: mục đích là tăng tốc độ, table level blocking
  + hỗ trợ full text index
  + không hỗ trợ transaction
  + không hỗ trợ foreign key 
  + tăng tốc độ ghi, vì nó ghi vào buffer trên memory, sau đó ghi vào memrory
  + server bị crash, 
3) Sự khác nhau giữa having và where
4) thứ tự thực hiện các mệnh đề trong câu lệnh select
5) Khác nhau giữa char vs varchar
6) Tăng performance câu lệnh truy vấn

queue
- queue driver : nơi lưu trữ thông tin queue = database => table jobs
cronjob
char vs varchar
================================
1) bắt tất cả các lỗi và throw exception
set_error_handler function
2) memory cache và memory cache
3) 1 class có nhiều contructor php được không
4) single pattern trong laravel
1 class chỉ có 1 instance
5) phân biệt giữa unit test và function test
6) ưu điểm của laravel
7) con trỏ trong eloquent
=> xem được câu sql
================
1) Cách optimize size image
2) Cách nào clone object mà k bị tham chiếu
3) Đã dùng BEM bao giờ chưa, vì sao nên dùng BEM khi viết css
4) Cách truyền data giữa component cha-con, con - cha, giữa các component với nhau
5) phân biệt giữa nuxtjs và vuejs
========================
1) kể về technical mà thấy hay trong các dự án
2) docker
3) xử lý service chuyển tiền
4) mineset code
dùng service để hạn chế sử dụng lại code
=========================
1) khác nhau giữa inline và block css
2) prevent render trong function component và class component
3) Dùng react hook để làm gì
4) khác nhau giữa es5 và es6
5) splice, slice trong array

php đa thừa kế?

khóa chính vs khóa ngoại

khóa chính có phải index k? *Index thường được tạo mặc định cho primary key, foreign key*
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
