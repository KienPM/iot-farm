# Mô tả

- Một store có nhiều **trunk**. Một **trunk** có nhiều **basket**
- Khi khởi tạo 1 store thì admin đã add một số nhất định các **trunk** vào trong store đó.
- Khi muốn thêm một số **trunk** thì admin có thể sửa store và thêm **trunk** vào
- Mặc định một **trunk** có 13 **basket**

# Đăng nhập

## Xem thông tin đăng nhập

**GET http://farm.ongnhuahdpe.com/partner/session**

## Đăng nhập

**POST http://farm.ongnhuahdpe.com/partner/session/login**

Data của gói tin post gửi đi: Sử dụng partner test đã tạo sẵn dưới đây. Tài khoản của partner là tài khoản do admin tạo ra, không đăng kí thông thường được.

```
{
    email: 'hoanghoi1310@gmail.com',
    password: '12344321',
}
```

Kết quả nhận được là thông tin user đang đăng nhập.

# Partner API

**Chú ý:** Partner phải đăng nhập vào hệ thống thì mới gửi được các request dưới đây.

## Xem danh sách rau có trong hệ thống

**GET http://farm.ongnhuahdpe.com/partner/vegetables**

Dữ liệu trả về là danh sách các loại rau có trong hệ thống, có phân trang.

- Xem sang trang 2: **GET http://farm.ongnhuahdpe.com/partner/vegetables?page=2**
- Xem all: **GET http://farm.ongnhuahdpe.com/partner/vegetables?all=1**

## Xem các store thuộc quyền sở hữu của mình

**GET http://farm.ongnhuahdpe.com/stores**

Dữ liệu trả về là danh sách các store mà partner đó sỡ hữu, có phân trang.

- Xem sang trang 2: **GET http://farm.ongnhuahdpe.com/partner/stores?page=2**
- Xem all: **GET http://farm.ongnhuahdpe.com/partner/stores?all=1**

## Xem các trunk có trong một store của mình

**GET http://farm.ongnhuahdpe.com/partner/stores/{store_id}/trunks**

Dữ liệu trả về là danh sách các trunks mà có trong store đó, có phân trang. `{store_id}` Là id của store cần xem

- Xem sang trang 2: **GET http://farm.ongnhuahdpe.com/partner/stores/11/trunks?page=2**
- Xem all: **GET http://farm.ongnhuahdpe.com/partner/stores/11/trunks?all=1**

***Chú ý:*** Partner chỉ xem được chi tiết store của mình. Không xem được chi tiết store của partner khác.

## Cập nhật trạng thái các basket của 1 trunk

Gửi gói tin post vào link với data ở bên dưới.

**POST http://farm.ongnhuahdpe.com/partner/stores/11/trunks/status**

Data của gói tin post gửi đi:

```
{
    trunk_status: [
        {
            'trunk_id': 12,   // Là cái id của trunk khi gửi request lấy danh sách trunks
            'vegetable_id': 3,
            'number_grow_day': 60,
            'planting_day': '2017-12-06 09:40:59',    // Phải đúng định dạng ngày tháng như vậy
            'basket_1': 0,
            'basket_2': 1,
            'basket_3': 0,
            'basket_4': 0,
            'basket_5': 0,
            'basket_6': 0,
            'basket_7': 0,
            'basket_8': 1,
            'basket_9': 1,
            'basket_10': 0,
            'basket_11': 1,
            'basket_12': 1,
            'basket_13': 0,
        },
        // cập nhật status cho trunk thứ 2
        {
            'trunk_id': 13,
            'vegetable_id': 3,
            'number_grow_day': 60,
            'planting_day': '2017-12-06 09:40:59',
            'basket_1': 0,
            'basket_2': 1,
            'basket_3': 0,
            'basket_4': 0,
            'basket_5': 0,
            'basket_6': 0,
            'basket_7': 0,
            'basket_8': 1,
            'basket_9': 1,
            'basket_10': 0,
            'basket_11': 1,
            'basket_12': 1,
            'basket_13': 0,
        },
        // Nếu muốn cập nhật thông tin của nhiều trunk thì thêm vào bên dưới.
    ]
}
```
