Người thực hiện: Lê Trần Văn Chương.
Thời gian: 21/04/2022.
Mục lục:
- [Authentication - Authorization](#authentication---authorization)
- [Lab](#lab)
  - [Authentication](#authentication)
    - [Testing for Credentials Transported over an Encrypted Channel (OTG-AUTHN-001)](#testing-for-credentials-transported-over-an-encrypted-channel-otg-authn-001)
    - [Testing for default credentials (OTG-AUTHN-002)](#testing-for-default-credentials-otg-authn-002)
    - [Testing for Weak lock out mechanism (OTG-AUTHN-003)](#testing-for-weak-lock-out-mechanism-otg-authn-003)
    - [Testing for bypassing authentication schema (OTG-AUTHN-004)](#testing-for-bypassing-authentication-schema-otg-authn-004)
    - [Test remember password functionality (OTG-AUTHN-005)](#test-remember-password-functionality-otg-authn-005)
    - [Testing for Browser cache weakness (OTG-AUTHN-006)](#testing-for-browser-cache-weakness-otg-authn-006)
    - [Testing for Weak password policy (OTG-AUTHN-007)](#testing-for-weak-password-policy-otg-authn-007)
    - [Testing for Weak security question/answer (OTG-AUTHN-008)](#testing-for-weak-security-questionanswer-otg-authn-008)
    - [Testing for weak password change or reset functionalities (OTG-AUTHN-009)](#testing-for-weak-password-change-or-reset-functionalities-otg-authn-009)
    - [Testing for Weaker authentication in alternative channel (OTG-AUTHN-010)](#testing-for-weaker-authentication-in-alternative-channel-otg-authn-010)
  - [Authorization](#authorization)
    - [Testing Directory traversal/file include (OTG-AUTHZ-001)](#testing-directory-traversalfile-include-otg-authz-001)
    - [Testing for bypassing authorization schema (OTG-AUTHZ-002)](#testing-for-bypassing-authorization-schema-otg-authz-002)
    - [Testing for Privilege Escalation (OTG-AUTHZ-003)](#testing-for-privilege-escalation-otg-authz-003)
    - [Testing for Insecure Direct Object References (OTG-AUTHZ-004)](#testing-for-insecure-direct-object-references-otg-authz-004)

## Authentication - Authorization
- Authentication (xác thực) nghĩa là xác minh danh tính của user.
- Authorization (ủy quyền) nghĩa là cấp quyền truy cập và hệ thống (user có quyền gì trong hệ thống).

| Authentication  | Authorization |
| ------------- |---------------|
| Authentication xác nhận danh tính của bạn để cấp quyền truy cập vào hệ thống.      | Authorization xác định xem bạn có được phép truy cập tài nguyên không.     |
| Đây là quá trình xác nhận thông tin đăng nhập để có quyền truy cập của người dùng.      | Đó là quá trình xác minh xem có cho phép truy cập hay không.     |
| Nó quyết định liệu người dùng có phải là những gì anh ta tuyên bố hay không.     | Nó xác định những gì người dùng có thể và không thể truy cập.    |
| Authentication thường yêu cầu tên người dùng và mật khẩu.     | Các yếu tố xác thực cần thiết để authorization có thể khác nhau, tùy thuộc vào mức độ bảo mật.     |
| Authentication là bước đầu tiên của authorization vì vậy luôn luôn đến trước.      | Authorization được thực hiện sau khi authentication thành công.    |

## Lab
Link: https://00bluec10.000webhostapp.com/index.php

### Authentication
#### Testing for Credentials Transported over an Encrypted Channel (OTG-AUTHN-001)
Tôi sử dụng `Burp Suite` để có thể bắt được các gói `header` và kiểm tra chúng.
![Hình 1.](~/../img/1.png)

#### Testing for default credentials (OTG-AUTHN-002)
- Sử dụng `intruder` của `Burp Suite` để có thể payload `email` và `password`. Tôi sử dụng chế độ `Cluster bomb` để có thể đặt nhiều payload trong 1 lần và tiết kiệm thời gian. 
![Hình 2.](~/../img/2.png)
- Tôi sử dụng 2 list sau để payload.
![Hình 3.](~/../img/3.png)
- Kết quả, tôi chỉ cần kiểm tra `Response` có chữ `Xin chào` hay không để có thể biết tài khoản này dùng được không.
![Hình 4.](~/../img/4.png)

#### Testing for Weak lock out mechanism (OTG-AUTHN-003)
Để kiểm tra cơ chế khóa tài khoản, bạn cần phải có 1 tài khoản để có thể vào được. Sau đó tiến hành kiểm tra như sau:
- Đăng nhập tài khoản bằng mật khẩu ko chính xác 3 lần, rồi đăng nhập lại bằng mật khẩu chính xác: 
  - Nếu đăng nhập thành công, cho thấy rằng cơ chế khóa không kích hoạt sau 3 lần xác thực không chính xác. Và ta cứ tiếp tục tăng số lần nhập mật khẩu sai lên đến khi `Tài khoản bị khóa`.
  - Nếu ứng dụng trả về `Tài khoản bị khóa` thì xác nhận rằng tài khoản đã bị khóa sau 3 lần xác thực sai.

#### Testing for bypassing authentication schema (OTG-AUTHN-004)
- Tiếp tục sử dụng `Burp Suite` để có thể lấy được `header` của web.
- Dùng `Send to Repeater` để có thể gửi request từ `Burp Suite` và `Send to Comparer` để kiểm tra sự thay đổi của `header` khi tôi login thành công.
![Hình 5.](~/../img/5.png)
![Hình 6.](~/../img/6.png)
- Dưới là bảng so sánh 2 `header`
![Hình 7.](~/../img/7.png)
- Bây giờ, tôi sẽ copy phần thay đổi khi login thành công và paste vào phần `header` khi chưa login. Và kết quả ở dưới.
![Hình 8.](~/../img/8.png)

#### Test remember password functionality (OTG-AUTHN-005)
Sử dụng `Burp Suite` để kiểm tra các cookie được ứng dụng lưu trữ. Ở đây, nó không được mã hóa hoặc băm gì hết.
![Hình 9.](~/../img/9.png)

#### Testing for Browser cache weakness (OTG-AUTHN-006)

#### Testing for Weak password policy (OTG-AUTHN-007)
Độ yếu của passsword chia ra làm 3 level:
![Hình 10.](~/../img/10.png)
- `Level 1`: password là `password` toàn những ký tự thường. Password ở đây khá tệ, vì với password toàn những chữ cái thường như `password` mà không có ký tự đặc biệt hoặc in hoa thì thường dễ bị tấn công vét cạn. Giả sử, ở `Level 1` này không thể register thì ta chuyển sang `Level 2`.
![Hình 11.](~/../img/11.png)
- `Level 2`: password là `passworD` có thêm ký tự in hoa là 'D'. Vì password này, có thêm ký tự in hoa nên khả năng vét cạn sẽ tốn nhiều thời gian hơn. Giả sử, ở `Level 2` này không thể register thì ta chuyển sang `Level 3`.
![Hình 12.](~/../img/12.png)
- `Level 3`: password là `P@sw0rd` vừa có ký tự thường, in hoa, số và ký tự đặc biệt nhưng ít hơn 8 ký tự. Web vẫn tiếp tục cho register.
Đây là 1 lỗi bảo mật `password`.


#### Testing for Weak security question/answer (OTG-AUTHN-008)

#### Testing for weak password change or reset functionalities (OTG-AUTHN-009)

#### Testing for Weaker authentication in alternative channel (OTG-AUTHN-010)


### Authorization

#### Testing Directory traversal/file include (OTG-AUTHZ-001)
#### Testing for bypassing authorization schema (OTG-AUTHZ-002)
#### Testing for Privilege Escalation (OTG-AUTHZ-003)
#### Testing for Insecure Direct Object References (OTG-AUTHZ-004)







