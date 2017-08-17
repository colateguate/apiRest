<?php

use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use App\Seller;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// Factory para Users
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verificado = $faker->randomElement([User::USER_VERIFICADO, User::USER_NO_VERIFICADO]),
        'verification_token' => $verificado == User::USER_VERIFICADO ? null : User::generarVerificationToken(),
        'admin' => $faker->randomElement([User::USER_ADMIN, User::USER_REGULAR]),
    ];
});

// Factory para Categories
$factory->define(Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

// Factory para Products
$factory->define(Product::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1,50),
        'status' => $faker->randomElement([Product::PRODUCTO_DISPONIBLE, Product::PRODUCTO_NO_DISPONIBLE]),
        'image' => $faker->randomElement(['chocapic.jpeg', 'cornFlakes.jpeg', 'goldenGraham.jpeg']),
        'seller_id' => User::inRandomOrder()->first()->id,
    ];
});

// Factory para Transaction
$factory->define(Transaction::class, function (Faker\Generator $faker) {

	$vendedor = Seller::has('products')->get()->random();
	$comprador 	= User::all()->except($vendedor -> id)->random();

    return [
        'quantity' => $faker->numberBetween(1,3),
        'buyer_id' => $comprador->id,
        'product_id' => $vendedor->products->random()->id,
    ];
});




