## Base link
- Server domain: http://li1626-27.members.linode.com/

- User: link sẽ là link mặc định
- admin: sẽ thêm /admin
- Đối tác: sẽ thêm /partner
- Thiết bị, Cảm biến: sẽ thêm /device

**Ví dụ:** Domain của server là iot-farm.vn thì trang xem trạng thái đăng nhập sẽ là
- admin: http://iot-farm.vn/admin/session
- user: http://iot-farm.vn/session
- partner: http://iot-farm.vn/partner/session
- device: http://iot-farm.vn/device/session

## Chú ý
### Các POST request phải có token trên header
X-CSRF-TOKEN: token_nhan_duoc

### Tất cả cá request phải có Header accept json
Accept: application/json

## Tài khoản đăng nhập
### Admin

**email:** hoanghoi1310@gmail.com

**password:** 12344321

### Partner

**email:** hoanghoi1310@gmail.com

**password:** 12344321

### User

**email:** hoanghoi1310@gmail.com

**password:** 12344321

### Device

**identify_code:** AAAAA0000000001

**password:** 12344321

## Login
### 1. Xem thông tin đăng nhập

**Path:** /session

**Method:** GET

**Response:**

- Khi đã đăng nhập

200

```
{
    status: 'logined',
    user: {
        name: 'xyz',
        email: 'abc@gmail.com',
        phone_number: '1234'
    },
    auth_token: 'token_dung_de_dang_nhap_socket',
    token: 'token_dung_de_gui_post_request'
}
```

- Khi chưa đăng nhập

401

```
{
    status: 'not_login',
    message: 'User not logged in!',
    token: 'token_dung_de_gui_post_request'
}
```

###  2. Đăng nhập

**Path:** /session/login

**Method:** POST

**Response:**

- Login success:

200

```
{
    status: 'logined',
    user: {
        name: 'xyz',
        email: 'abc@gmail.com',
        phone_number: '1234'
    },
    auth_token: 'token_dung_de_dang_nhap_socket',
    token: 'token_dung_de_gui_post_request'
}
```

- Login fail:

401

```
{
    status: 'not_login',
    message: 'These credentials do not match our records.',
    token: 'token_dung_de_gui_post_request'
}
```

###  3. Logout

**Path:** /session/logout

**Method:** POST

**Response:**

- logout thành công:

401

```
{
    status: 'not_login',
    message: 'User not logged in!',
    token: 'token_dung_de_gui_post_request'
}
```

- Chưa đăng nhập mà gửi logout request: sẽ gửi thông báo lỗi không được tiếp tục truy nhập.

400

```
{
    status: 'error',
    message: 'Can not continue executing request!'
}
```

## Đăng nhập socket server

- Để đăng nhập vào socket server thì lắng nghe sự kiện `connect` để emit sự kiện `authenticate` với data là `{token: 'auth_token_nhan_duoc'}`.

```
socket.on('connect', function () {
    socket.emit('authenticate', {token: result.auth_token});
});
```

## Store API
### Admin

*Chú ý:* prefix của admin là có `/admin`

#### 1. Xem danh sách store

**Mô tả:** Xem danh sách các store trong hệ thống bao gồm cả store đang active và không active

**Path:** /stores

**Method:** GET

**Response:** Cấu trúc

```
{
    "data": [
        {
            "id": 3501,
            "partner_id": 3502,
            "address": "25861 Everette Inlet Suite 799",
            "info": "534 Hoppe Locks",
            "is_actived": 1,
            "created_at": "2017-07-29 17:02:09",
            "updated_at": "2017-07-29 17:02:09",
            "partner": {
                "id": 3502,
                "name": "Bryana Lang",
                "email": "jerde.freda@example.net",
                "phone_number": "1-877-684-1034",
                "is_actived": 1,
                "created_at": "2017-07-29 17:02:09",
                "updated_at": "2017-07-29 17:02:09"
            }
        },
        {
            "id": 1799,
            "partner_id": 1800,
            "address": "8534 Elyse Trail",
            "info": "82875 Haley Spring Suite 067",
            "is_actived": 1,
            "created_at": "2017-07-29 17:00:52",
            "updated_at": "2017-07-29 17:00:52",
            "partner": {
                "id": 1800,
                "name": "Prof. Caroline Kuhic Jr.",
                "email": "lward@example.com",
                "phone_number": "800.887.8844",
                "is_actived": 1,
                "created_at": "2017-07-29 16:59:19",
                "updated_at": "2017-07-29 16:59:19"
            }
        }
    ],
    "current_page": 1, //page hiện tại
    "from": 1, //Item bắt đầu
    "last_page": 2, //page cuối = max page
    "next_page_url": "http://iot-farm.vn/admin/stores?page=2",
    "path": "http://iot-farm.vn/admin/stores",
    "per_page": 10, //số items max trong 1 page
    "prev_page_url": null,
    "to": 10, //Item kết thúc
    "total": 14 //số lượng items
}
```

**Thêm tùy chọn:**
Search: Tìm kiếm theo địa chỉ hoặc mô tả trong của store: `/stores?quick_search=<addr or infor>&page=2`

Tạm thời cho tìm kiếm cơ bản, sau sẽ có tìm kiếm nâng cao, tìm store theo loại rau, mức giá,...

Items Per page: Số items trong 1 page, mặc định là 10. Có thể set bằng query: `/stores?items_per_page=20`


#### 2. Chi tiết store

**Mô tả** Xem chi tiết một store bao gồm các thông tin loại rau có trong store đó và giá bán từng loại.

**Path:** /stores/<store id>

**Method:** GET

**Response:**

#### 3. Danh sách các cảm biến có trong store

**Mô tả** Xem chi tiết một store bao gồm các thông tin cảm biến có trong store, loại cảm biến.

**Path:** /stores/<store id>/devices

**Method:** GET

**Response:**


## Thông báo lỗi
### Link không tồn tại (not found)
```
{
    status: 'warning',
    message: 'Not found!'
}
```

## Quá trình gửi request
### Đăng nhập

- Gửi request get xem thông tin đăng nhập
- Nhận được `token`
- Sử dụng token này để gửi request post đăng nhập.

*Chú ý:* POST request phải có một trường `_token` = token bên trên. Hoặc phải được set header:  `X-CSRF-TOKEN` = 'token'. Hoặc đưa token này lên url: http://farm.vn/?_token=token. Xem https://laravel.com/docs/5.4/csrf#csrf-x-csrf-token để biết thêm chi tiết.

- Sau khi đăng nhập thì sẽ nhận được `auth_token`. Dùng `auth_token` để đăng nhập socket server. Socket server sẽ lắng nghe ở cổng 3000 và cùng tên miền với php server (cái này có thể thay đổi).


Nếu biết một chút code web có thể xem ví dụ ở file `/static/auth.html`

###  2.

**Path:**

**Method:**

**Response:**

