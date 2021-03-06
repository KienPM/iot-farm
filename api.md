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

**Data:**

Đăng nhập bằng tài khoản thường
```
{
    email: 'hoanghoi1310@gmail.com',
    password: '12344321'
}
```

Đăng nhập bằng social account
```
{
    name: 'hoanghoi', //bắt buộc phải có, có thể trùng tên đã có trong hệ thống.
    email: 'hoanghoi1310@gmail.com', //Không nhất thiết phải có, nếu email trùng với email đã đăng kí tài khoản thì chỉ thêm social account chứ ko tạo user mới. Nếu Email chưa có trong hệ thống thì sẽ tạo user mới.
    provider: '1', //bắt buộc phải có
    provider_user_token: 'provider_token_provider_token_provider_token', //bắt buộc phải có
}
```

**Lưu ý:**

- provider = 1 ==> facebook
- provider = 2 ==> google
- provider = khác ==> không đăng nhập đc

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

### 4. Đăng kí thông thường (chỉ user)

**Path:** /session/register

**Method:** POST

**Data:**

```
{
    name: 'hoanghoi',
    email: 'user.email@gmail.com',
    password: '12344321',
    password_confirmation: '12344321',
}
```

**Response:**

Dữ liệu trả về như là lúc đăng nhập thành công.


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
            "id": 17157,
            "partner_id": 17186,
            "address": "2581 Reynolds Ways Apt. 906",
            "info": "97487 Schamberger Extensions Apt. 485",
            "longitude": 105.18142,
            "latitude": 21.356983,
            "is_actived": 1,
            "created_at": "2017-08-05 09:39:30",
            "updated_at": "2017-08-05 09:39:30",
            "partner": {
                "id": 17186,
                "name": "Arlie Glover",
                "email": "roosevelt96@bartoletti.org",
                "phone_number": "(866) 977-5262",
                "is_actived": 1,
                "created_at": "2017-08-05 09:39:30",
                "updated_at": "2017-08-05 09:39:30"
            }
        },
        {
            "id": 17156,
            "partner_id": 17185,
            "address": "4467 Otto Meadows Apt. 735",
            "info": "2876 Koelpin Estate Apt. 084",
            "longitude": 105.769321,
            "latitude": 21.082853,
            "is_actived": 1,
            "created_at": "2017-08-05 09:39:30",
            "updated_at": "2017-08-05 09:39:30",
            "partner": {
                "id": 17185,
                "name": "Dr. Noemy Weimann",
                "email": "wherman@cassin.com",
                "phone_number": "(844) 403-5219",
                "is_actived": 1,
                "created_at": "2017-08-05 09:39:30",
                "updated_at": "2017-08-05 09:39:30"
            }
        }
    ],
    "current_page": 1, //page hiện tại
    "from": 1, //Item bắt đầu
    "last_page": 2, //page cuối = max page
    "next_page_url": "http://farm.ongnhuahdpe.com/admin/stores?page=2",
    "path": "http://farm.ongnhuahdpe.com/admin/stores",
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
```
{
    "id": 7146,
    "partner_id": 7175,
    "address": "84671 Hintz Park Apt. 707",
    "info": "1392 Stark Track Suite 637",
    "longitude": 105.871304,
    "latitude": 21.085919,
    "is_actived": 1,
    "created_at": "2017-08-05 08:31:03",
    "updated_at": "2017-08-05 08:31:03",
    "partner": {
        "id": 7175,
        "name": "Mr. Kiel Dickinson Sr.",
        "email": "baumbach.rosalinda@krajcik.com",
        "phone_number": "(800) 628-8855",
        "is_actived": 1,
        "created_at": "2017-08-05 08:31:01",
        "updated_at": "2017-08-05 08:31:01"
    },
    "vegetables": [
        {
            "id": 1,
            "name": "Khaki",
            "description": "Alice as he spoke, and then hurried on, Alice started to her daughter 'Ah, my dear! Let this be a queer thing, to be listening, so she turned away. 'Come back!' the Caterpillar took the hookah out.",
            "is_actived": 1,
            "created_at": "2017-08-05 08:24:58",
            "updated_at": "2017-08-05 08:24:58",
            "pivot": {
                "store_id": 7146,
                "vegetable_id": 1,
                "price": 15
            }
        }
    ]
}
```
#### 3. Danh sách các cảm biến có trong store

**Mô tả** Xem chi tiết một store bao gồm các thông tin cảm biến có trong store, loại cảm biến.

**Path:** /stores/<store id>/devices

**Method:** GET

**Response:**
```
{
    "status": "success",
    "data": {
        "id": 7146,
        "partner_id": 7175,
        "address": "84671 Hintz Park Apt. 707",
        "info": "1392 Stark Track Suite 637",
        "longitude": 105.871304,
        "latitude": 21.085919,
        "is_actived": 1,
        "created_at": "2017-08-05 08:31:03",
        "updated_at": "2017-08-05 08:31:03",
        "devices": [
            {
                "id": 15502,
                "store_id": 7146,
                "category_id": 2,
                "name": "Daphne Haag",
                "identify_code": "PCLBC5860837224",
                "is_actived": 1,
                "created_at": "2017-08-05 09:31:58",
                "updated_at": "2017-08-05 09:31:58",
                "category": {
                    "id": 2,
                    "name": "Cleve Jacobs",
                    "symbol": "provident"
                }
            }
        ]
    }
}
```

#### 4. Create store
**Mô tả** Create một store

**Path:** /stores

**Method:** POST

**Data:**
```
{
    partner_id: 1234,
    address: '84671 Hintz Park Apt. 707',
    info: '1392 Stark Track Suite 637',
    latitude: 105.871304,
    longitude: 21.085919,
    is_actived: true,
}
```
**Response:**

#### 4. Update store
**Mô tả** Admin Update các thông tin cơ bản của store

**Path:** /stores/<store id>

**Method:** POST
**Data:**
```
{
    partner_id: 1234,
    address: '84671 Hintz Park Apt. 707',
    info: '1392 Stark Track Suite 637',
    latitude: 105.871304,
    longitude: 21.085919,
    is_actived: true,
}
```
**Response:**
```
{
    "status": "success",
    "message": "Update store successful!",
    "id": 7146,
    "partner_id": "7175",
    "address": "84671 Hintz Park Apt. 707",
    "info": "1392 Stark Track Suite 637",
    "longitude": "21.085919",
    "latitude": "105.871304",
    "is_actived": "1",
    "created_at": "2017-08-07 15:27:21",
    "updated_at": "2017-08-23 02:47:28",
    "partner": {
        "id": 7175,
        "name": "Prof. Gene Vandervort Sr.",
        "email": "nestor66@hotmail.com",
        "phone_number": "800-261-1139",
        "is_actived": 1,
        "created_at": "2017-08-07 15:27:25",
        "updated_at": "2017-08-07 15:27:25"
    }
}
```
#### 5. Delete store

**Mô tả** Admin xóa store, các device và liên kết liên quan

**Path:** /stores/<store id>/delete

**Method:** POST
**Data:**


## 6 User Order
### List cart items

**Mô tả:** User list all item to cart

**Path:** /cart/items

**Method:** GET

**Data:**

### Add items to cart

**Mô tả:** User add one item to cart

**Path:** /cart/items

**Method:** POST

**Data:**
```
{
    vegetables: [
        {id: 6, quantity: 3},
        {id: 3, quantity: 3},
        {id: 2, quantity: 3},
    ],
    store_id: 101
}
```

**Response:** Giống list items. `status = success` là add thành công. `status = error` là add ko thành công

**Chú ý:**

- Nếu không có quantity thì mặc định là 1
- Nếu không có rau nào được tìm thấy thì sẽ báo lỗi.


### Update items in cart

**Mô tả:** Người dùng update quantity và checked cho một item trong cart. Có thể gửi request chỉ chứa 1 trong 2 trường quantity và checked. Checked là là đánh dấu, sản phẩm nào trong cart được thanh toán (checkout). Mặc định khi add thêm mới thì sản phẩm sẽ được checked.

**Path:** /cart/items/{itemID}

**Method:** POST

**Data:**
```
{
    quantity: 3,
    checked: 101
}
```

**Response:** Giống list items. `status = success` là update thành công. `status = error` là update ko thành công

### Delete cart items

**Mô tả:** User xóa 1 hoặc nhiều item ra khỏi cart

**Path:** /cart/items/delete

**Method:** POST

**Data:** Truyền vào một mảng items bao gồm các id cần xóa
```
{
    items: [1, 2, 3]
}
```
**Response:** Giống list items. `status = success` là xóa thành công. `status = error` là xóa ko thành công

## 7. User search stores

### Mô tả

User chọn các loại rau, sau đó tìm kiếm các cửa hàng có tất cả các loại rau đấy.

### Xem các loại rau có trong hệ thống

**Path:** /vegetables

**Method:** GET

### Tìm kiếm cửa hàng

**Path:** /stores

**Method:** POST hoặc GET

**Data:** Truyền vào một mảng vegetable id nếu muốn tìm theo danh sách rau
```
{
    vegetables: [1, 2, 3]
}
```

**Response:**

Danh sách store thỏa mãn điều kiện. Trả về như list stores. 

**Thông tin thêm:**
- Url này chấp nhận cả POST và GET  request
- Kết quả trả về có phân trang. Có thể thay đổi số items trên 1 trang qua param `items_per_page=số trang` . Có thể hiện thị tất cả các kết quả bằng param `all=1`
- Sắp xếp theo tọa độ gần nhất nếu có thuộc tính `latitude` và `longitude`. Ví dụ: `/stores?latitude=20.9813732=&longitude=105.8370336`
- Tìm kiếm theo địa chỉ, thông tin chi tiết `?quick_search=tu_khoa_can_tim`

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

- Gửi request get xem thông tin đăng nhập: GET /session
- Nhận được `token`
- Sử dụng token này để gửi request post đăng nhập. POST /session/login

*Chú ý:* POST request phải có một trường `_token` = token bên trên. Hoặc phải được set header:  `X-CSRF-TOKEN` = 'token'. Hoặc đưa token này lên url: http://farm.vn/?_token=token. Xem https://laravel.com/docs/5.4/csrf#csrf-x-csrf-token để biết thêm chi tiết.

- Sau khi đăng nhập thì sẽ nhận được `auth_token`. Dùng `auth_token` để đăng nhập socket server. Socket server sẽ lắng nghe ở cổng 3000 và cùng tên miền với php server (cái này có thể thay đổi).


Nếu biết một chút code web có thể xem ví dụ ở file `/static/auth.html`

###  2.

**Path:**

**Method:**

**Response:**

