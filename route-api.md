## Base link
- Server domain: http://farm.ongnhuahdpe.com/

- User: link sẽ là link mặc định
- admin: sẽ thêm /admin
- Đối tác: sẽ thêm /partner
- Thiết bị, Cảm biến: sẽ thêm /device

**Ví dụ:** Domain của server là iot-farm.vn thì trang xem trạng thái đăng nhập sẽ là
- admin: http://farm.ongnhuahdpe.com/admin/session
- user: http://farm.ongnhuahdpe.com/session
- partner: http://farm.ongnhuahdpe.com/partner/session
- device: http://farm.ongnhuahdpe.com/device/session

## Chú ý
### Các POST request phải có token trên header
X-CSRF-TOKEN: token_nhan_duoc

### Tất cả cá request phải có Header accept json
Accept: application/json

## Route

