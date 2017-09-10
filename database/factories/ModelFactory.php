<?php

use App\Models\Admin;
use App\Models\BankAccount;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Partner;
use App\Models\SocialUser;
use App\Models\Store;
use App\Models\User;
use App\Models\VegetableCategory;
use App\Models\Vegetable;
use App\Models\Trunk;
use App\Models\TrunkStatus;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/**
    $faker->addProvider(new Faker\Provider\en_US\Person($faker));
    $faker->addProvider(new Faker\Provider\en_US\Address($faker));
    $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));
    $faker->addProvider(new Faker\Provider\en_US\Company($faker));
    $faker->addProvider(new Faker\Provider\en_US\Text($faker));
    $faker->addProvider(new Faker\Provider\Lorem($faker));
    $faker->addProvider(new Faker\Provider\Internet($faker));
    $faker->addProvider(new Faker\Provider\en_US\Payment($faker));
**/

$factory->define(Trunk::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\Base($faker));
    static $code = 1;

    return [
        'code' => $code++,
        'store_id' => function() {
            return factory(Store::class)->create()->id;
        },
        'is_actived' => true,
    ];
});

$factory->define(TrunkStatus::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\Base($faker));
    $faker->addProvider(new Faker\Provider\DateTime($faker));
    return [
        'trunk_id' => function() {
            return factory(Trunk::class)->create()->id;
        },
        'vegetable_id' => function() {
            return factory(Vegetable::class)->create()->id;
        },
        'number_grow_day' => $faker->numberBetween(30, 120),
        'planting_day' => $faker->dateTimeBetween('-1 years', 'now'),
        'basket_1' => $faker->numberBetween(0, 1),
        'basket_2' => $faker->numberBetween(0, 1),
        'basket_3' => $faker->numberBetween(0, 1),
        'basket_4' => $faker->numberBetween(0, 1),
        'basket_5' => $faker->numberBetween(0, 1),
        'basket_6' => $faker->numberBetween(0, 1),
        'basket_7' => $faker->numberBetween(0, 1),
        'basket_8' => $faker->numberBetween(0, 1),
        'basket_9' => $faker->numberBetween(0, 1),
        'basket_10' => $faker->numberBetween(0, 1),
        'basket_11' => $faker->numberBetween(0, 1),
        'basket_12' => $faker->numberBetween(0, 1),
        'basket_13' => $faker->numberBetween(0, 1),
    ];
});

$factory->define(Admin::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->freeEmail,
        'password' => bcrypt('12344321'),
        'phone_number' => $faker->tollFreePhoneNumber(),
        'remember_token' => str_random(10),
        'is_actived' => true,
    ];
});

$factory->define(BankAccount::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\en_US\Payment($faker));

    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'account' => $faker->unique()->bankAccountNumber(),
    ];
});


$factory->define(Device::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'password' => bcrypt('12344321'),
        'identify_code' => $faker->unique()->regexify('[A-Z]{5}[0-9]{10}'),
        'store_id' => function() {
            return factory(Store::class)->create()->id;
        },
        'category_id' => function() {
            return factory(DeviceCategory::class)->create()->id;
        },
        'is_actived' => true,
    ];
});

$factory->define(DeviceCategory::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\Lorem($faker));
    $faker->addProvider(new Faker\Provider\en_US\Text($faker));

    return [
        'name' => $faker->name,
        'symbol' => $faker->word,
        'description' => $faker->realText(),
    ];
});


$factory->define(Order::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\Base($faker));

    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'bank_account_id' => function() {
            return factory(BankAccount::class)->create()->id;
        },
        'store_id' => function() {
            return factory(Store::class)->create()->id;
        },
        'total_price' => $faker->randomNumber(),
        'status' => Order::ORDER_COMPLETED,
    ];
});


$factory->define(OrderItem::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\Base($faker));

    return [
        'order_id' => function() {
            return factory(Order::class)->create()->id;
        },
        'vegetable_in_store_id' => 1,
        'quantity' => $faker->randomNumber(),
    ];
});

$factory->define(Partner::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->companyEmail,
        'password' => bcrypt('12344321'),
        'phone_number' => $faker->tollFreePhoneNumber(),
        'remember_token' => str_random(32),
        'is_actived' => true,
    ];
});

$factory->define(SocialUser::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'provider' => SocialUser::FACEBOOK_ACCOUNT,
        'provider_user_token' => str_random(32),
    ];
});


$factory->define(Store::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\en_US\Address($faker));

    return [
        'partner_id' => function() {
            return factory(Partner::class)->create()->id;
        },
        'address' => $faker->streetAddress,
        'info' => $faker->streetAddress,
        'latitude' => $faker->latitude(20.7665365, 21.3909648),
        'longitude' => $faker->longitude(104.9722854, 105.9933738),
        'is_actived' => true,
    ];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->freeEmail,
        'password' => bcrypt('12344321'),
        'phone_number' => $faker->tollFreePhoneNumber(),
        'remember_token' => str_random(32),
        'is_actived' => true,
    ];
});

$factory->define(VegetableCategory::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\Lorem($faker));
    $faker->addProvider(new Faker\Provider\en_US\Text($faker));

    return [
        'name' => $faker->name,
        'description' => $faker->realText(),
    ];
});

$factory->define(Vegetable::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\Color($faker));
    $faker->addProvider(new Faker\Provider\en_US\Text($faker));
    $faker->addProvider(new Faker\Provider\Base($faker));

    return [
        'category_id' => function () {
            return factory(VegetableCategory::class)->create()->id;
        },
        'name' => $faker->colorName,
        'description' => $faker->realText(),
        'price' => $faker->randomNumber(),
        'is_actived' => true,
    ];
});
