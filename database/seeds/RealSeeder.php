<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Trunk;
use App\Models\TrunkStatus;

class RealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        DB::table('admins')->truncate();
        DB::table('devices')->truncate();
        DB::table('stores')->truncate();
        DB::table('users')->truncate();
        DB::table('partners')->truncate();
        DB::table('device_categories')->truncate();
        DB::table('vegetable_categories')->truncate();
        DB::table('vegetables')->truncate();
        DB::table('vegetable_in_store')->truncate();
        DB::table('trunks')->truncate();
        DB::table('trunk_status')->truncate();

        DB::table('admins')->insert([
            [
                'id' => 1,
                'name' => 'hoanghoi-admin',
                'email' => 'hoanghoi1310@gmail.com',
                'phone_number' => '0982708002',
                'is_super' => 1,
                'password' => bcrypt('12344321'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('partners')->insert([
            [
                'id' => 1,
                'name' => 'hoanghoi-partner',
                'email' => 'hoanghoi1310@gmail.com',
                'phone_number' => '0982708002',
                'password' => bcrypt('12344321'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'hoanghoi-user',
                'email' => 'hoanghoi1310@gmail.com',
                'phone_number' => '0982708002',
                'password' => bcrypt('12344321'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('stores')->insert([
            [
                'id' => 1,
                'partner_id' => 1,
                'name' => 'Cửa hàng rau sạch Định Công',
                'address' => 'Ngõ 175 Định Công, Hoàng Mai, Hà Nội',
                'info' => 'Cửa hàng rau sạch Định Công chuyên cung cấp các loại rau củ chất lượng tốt, trồng trên giàn thủy canh, không sâu bệnh, không thuốc bảo vệ thực vật, giá cả hợp lý, an toàn cho mọi gia đình.',
                'latitude' => 20.9813732,
                'longitude' => 105.8370336,
                'is_actived' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('device_categories')->insert([
            [
                'id' => 1,
                'name' => 'Cảm biến',
                'symbol' => 'C',
                'description' => 'Thiết bị đo điều kiện môi trường xung quanh',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Máy bơm',
                'symbol' => 'B',
                'description' => 'Thiết bị cung cấp chất dinh dưỡng cho giàn',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Đèn',
                'symbol' => 'D',
                'description' => 'Thiết bị chiếu sáng cho giàn',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'Quạt gió',
                'symbol' => 'E',
                'description' => 'Thiết bị điều hòa gió cho giàn',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
        ]);
        DB::table('devices')->insert([
            // Cam bien
            [
                'id' => 1,
                'identify_code' => 'AAAAA0000000001',
                'name' => 'Cảm biến nhiệt độ nước',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'identify_code' => 'AAAAA0000000002',
                'name' => 'Cảm biến nhiệt độ không khí',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'identify_code' => 'AAAAA0000000003',
                'name' => 'Cảm biến PH',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // May bom
            [
                'id' => 4,
                'identify_code' => 'BBBBB0000000001',
                'name' => 'Máy bơm 0',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'identify_code' => 'BBBBB0000000002',
                'name' => 'Máy bơm 1',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'identify_code' => 'BBBBB0000000003',
                'name' => 'Máy bơm 2',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Den
            [
                'id' => 7,
                'identify_code' => 'DDDDD0000000001',
                'name' => 'Đèn mạn trái',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'identify_code' => 'DDDDD0000000002',
                'name' => 'Đèn mạn phải',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            //Quat gio
            [
                'id' => 9,
                'identify_code' => 'EEEEE0000000001',
                'name' => 'Quạt gió chính',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'identify_code' => 'EEEEE0000000002',
                'name' => 'Quạt gió phụ',
                'password' => bcrypt('12344321'),
                'store_id' => 1,
                'category_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // VegetableCategory
        DB::table('vegetable_categories')->insert([
            [
                'id' => 1,
                'name' => 'Rau sống',
                'description' => 'Rau thường để ăn sống',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Rau xanh',
                'description' => 'Rau thường được nấu chín và chế biến thành các món ăn khác nhau',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Rau cải',
                'description' => 'Các loại rau thuộc họ cải',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Gia vị',
                'description' => 'Gia vị, theo định nghĩa của các nhà khoa học và sinh học, là những loại thực phẩm, rau thơm (thường có tinh dầu) hoặc các hợp chất hóa học cho thêm vào món ăn, có thể tạo những kích thích tích cực nhất định lên cơ quan vị giác, khứu giác và thị giác đối với người ẩm thực.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'name' => 'Củ, quả',
                'description' => 'Củ, quả',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Vegetable
        DB::table('vegetables')->insert([
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Xà lách',
                'description' => 'Rau chứa rất nhiều muối khoáng giúp mang lại sự tinh thần và tránh được nhiều bệnh tật.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'name' => 'Rau muống',
                'description' => 'Rau quen thuộc trong bữa ăn hàng ngày. Rau có tác dụng tốt, như: thanh nhiệt, giải độc, lợi tiểu,...',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'name' => 'Rau ngót',
                'description' => 'Ẩm thực Việt Nam dùng rau ngót nấu canh với thịt băm, hoặc có khi chỉ nấu suông vì rau có sẵn vị ngọt.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'category_id' => 3,
                'name' => 'Cải ngồng',
                'description' => 'Lọai rau đặc sản của khu vực miền Bắc. Ăn rau cải ngồng sẽ làm da dẻ mịn màng, tươi tắn, làm chậm quá trình lão hóa. Tăng sức đề kháng cho cơ thể.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'category_id' => 3,
                'name' => 'Cải ngọt',
                'description' => 'Cải ngọt thường được chế biến thành các món ăn như cải ngọt xào thịt, canh cải ngọt nấu tôm, rau cải ngọt luộc chấm xì dầu, cải ngọt xào thịt bò, cải ngọt xào chân gà..., làm lẩu cá, lẩu thịt.',
                'price' => 12000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'category_id' => 3,
                'name' => 'Cải bẹ xanh',
                'description' => 'Rau cải xanh chứa hàm lượng chất xơ rất lớn, chất nhầy. Chất nhầy sẽ hỗ trợ nhu động ruột, giúp tiêu hóa tốt hơn. Đồng thời, chất xơ giúp bạn ngăn ngừa táo bón.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'category_id' => 3,
                'name' => 'Cải thìa',
                'description' => 'Cải thìa tốt cho phụ nữ mang thai, có tác dụng phòng ngừa khuyết tật cho thai nhi, giúp xương chắc khỏe, có khả năng kích thích nhịp tim hoạt động tốt và hạ huyết áp. Cải thìa làm chậm quá trình lão hóa.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'category_id' => 2,
                'name' => 'Rau lang',
                'description' => 'Ăn rau lang xào tỏi rất tốt cho tiêu hóa. Cả củ và rau lang đều nhuận tràng, ăn nhiều trị được táo bón. Phụ nữ sau khi sinh có thể dùng ngọn hay lá rau lang nấu canh hoặc luộc ăn cho thêm sữa.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 70,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'category_id' => 1,
                'name' => 'Rau kinh giới',
                'description' => 'Rau kinh giới là loại rau gia vị phổ biến được sử dụng trong nhiều món ăn, trong rau có thành phần vitamin và khoáng chất, có thể điều trị được nhiều bệnh, kháng khuẩn và chống oxy hóa tốt.',
                'price' => 13000,
                'is_actived' => true,
                'number_grow_day' => 70,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'category_id' => 2,
                'name' => 'Mồng tơi',
                'description' => 'Mồng tơi là loại rau quen thuộc, được sử dụng để chế biến trong bữa ăn hàng ngày. rau mồng tơi có tính hàn, vị chua, tán nhiệt, mất máu, lợi tiểu, giải độc, đẹp da, trị rôm sảy mụn nhọt hiệu quả… rất thích hợp trong mùa nóng.',
                'price' => 14000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 11,
                'category_id' => 3,
                'name' => 'Cải cúc',
                'description' => 'Cải cúc dễ chế biến, giàu dinh dưỡng và có tác dụng chữa bệnh tốt với một số bệnh thông thường. Cải cúc có tác dụng chữa các bệnh như ít sữa sau sinh, trị đau đầu, hoa mắt, ...',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 12,
                'category_id' => 4,
                'name' => 'Hành lá',
                'description' => 'Hành luôn được coi là thực phẩm có tính kháng viêm cao. Ngoài ra, nó lại rất giàu vitamin A, B, C và là một nguồn dinh dưỡng thiên nhiên tiềm năng cung cấp acid folic, canxi, phốt pho, magiê, crom, sắt và chất xơ.',
                'price' => 5000,
                'is_actived' => true,
                'number_grow_day' => 40,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 13,
                'category_id' => 5,
                'name' => 'Củ cải trắng',
                'description' => 'Củ cải trắng là một món ăn phổ biến. Củ cải trắng tươi có vị cay, tính mát, khi nấu chín lại có vị ngọt, tính bình sở hữu công dụng thanh nhiệt, giải độc, kiện vị, tiêu thực, tiêu đờm, khỏi ho.',
                'price' => 15000,
                'is_actived' => true,
                'number_grow_day' => 80,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 14,
                'category_id' => 4,
                'name' => 'Sả',
                'description' => 'Không chỉ là gia vị đặc trưng trong bếp, sả còn là vị thuốc quý. Đông y đánh giá cao tác dụng giải độc, hỗ trợ tiêu hóa, hạ huyết áp, giải cảm và nhiều công dụng tuyệt vời khác.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 15,
                'category_id' => 1,
                'name' => 'Dấp cá',
                'description' => 'Trong dân gian còn có tên diếp cá, ngư tinh thảo, rau vẹn, tập thái. Là một loại rau rất tốt cho sức khỏe, có thể xay ra để uống trị một số bệnh như táo bón, chữa sốt cho trẻ em, ...',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 40,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 16,
                'category_id' => 5,
                'name' => 'Su hào',
                'description' => 'Su hào có thể ăn sống cũng như được đem luộc, nấu. Su hào chứa nhiều chất xơ tốt cho hệ tiêu hóa cũng như chứa các chất như selen, axít folic, vitamin C, kali, magiê và đồng.',
                'price' => 14000,
                'is_actived' => true,
                'number_grow_day' => 70,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 17,
                'category_id' => 1,
                'name' => 'Tía tô',
                'description' => 'Rau tía tô có mùi thơm, vị cay đặc trưng, tính ấm. Đồng thời, tía tô cũng là một loại thuốc chữa bệnh và phòng bệnh theo y học cổ truyền.',
                'price' => 10000,
                'is_actived' => true,
                'number_grow_day' => 50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 18,
                'category_id' => 4,
                'name' => 'Thì là',
                'description' => 'Rau thì là là một loại rau gia vị không thể thiếu trong các món canh cá, lẩu cả, mực,… giúp khử mùi tanh, làm cho món ăn thơm ngon hơn. Ngoài tác dụng trong ẩm thực ra, rau thì là còn có nhiều tác dụng trong việc chữa trị bệnh. ',
                'price' => 7000,
                'is_actived' => true,
                'number_grow_day' => 40,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 19,
                'category_id' => 4,
                'name' => 'Riềng',
                'description' => 'Riềng chứa các hoạt chất mang đặc tính kháng viêm nên rất có ích trong việc điều trị viêm khớp, thấp khớp, phong thấp, đau cơ bắp và giúp vết thương mau lành mà ít để lại sẹo. ',
                'price' => 11000,
                'is_actived' => true,
                'number_grow_day' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 20,
                'category_id' => 5,
                'name' => 'Bí đao',
                'description' => 'Bí đao, bí xanh  là loại quả dùng làm thực phẩm thông dụng cho mọi gia đình, nó cũng là loại quả đa công dụng nhất. Bí đao vừa dùng để chế biến đồ ăn, thức uống, vừa được chị em tin dùng trong việc làm đẹp, giảm cân...',
                'price' => 15000,
                'is_actived' => true,
                'number_grow_day' => 70,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('vegetable_in_store')->insert([
            [
                'id' => 1,
                'vegetable_id' => 1,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'vegetable_id' => 2,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'vegetable_id' => 3,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'vegetable_id' => 4,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'vegetable_id' => 5,
                'store_id' => 1,
                'price' => 12000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'vegetable_id' => 6,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'vegetable_id' => 7,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'vegetable_id' => 8,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'vegetable_id' => 9,
                'store_id' => 1,
                'price' => 13000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'vegetable_id' => 10,
                'store_id' => 1,
                'price' => 14000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 11,
                'vegetable_id' => 11,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 12,
                'vegetable_id' => 12,
                'store_id' => 1,
                'price' => 5000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 13,
                'vegetable_id' => 12,
                'store_id' => 1,
                'price' => 15000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 14,
                'vegetable_id' => 12,
                'store_id' => 1,
                'price' => 10000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 15,
                'vegetable_id' => 12,
                'store_id' => 1,
                'price' => 5000,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        factory(Trunk::class, 10)->create([
            'store_id' => 1,
        ])->each(function ($trunk) {
            factory(TrunkStatus::class, 5)->create([
                'trunk_id' => $trunk->id,
                'vegetable_id' => random_int(1, 15),
                'number_grow_day' => random_int(40, 80),
                'planting_day' => Carbon::now()->subDays(random_int(20, 40))->toDateTimeString(),
            ]);
        });
    }
}
