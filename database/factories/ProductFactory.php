<?php
/*Это файл созданный по команде php artisan make:factory ProductFactory.
Он нам заполнит таблицу products случайными товарами.*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Category;
use Faker\Generator as Faker;
/*На репозиторие faker мы нашли как создавать и пользоватся этим посевом данных.*/
$factory->define(Product::class, function (Faker $faker) {
	$categories = Category::all('id')->toArray();
    /*Для того чтоб получить id существующих категорий обращаемся к модели Category::
    Преобразовываем в массив и теперь все id лежат в массиве*/
    return [
        'name'=>$faker->words(3, true),
        'slug'=>$faker->unique()->slug(2, true),
        'img'=>$faker->imageURL(640, 480),
        'price'=>$faker->randomFloat(2, 1, 100),
        'description'=>$faker->text(500),
        'quantity'=>rand(0, 10),
        'recommended'=>rand(0, 1),
        'category_id'=>$categories[rand(0, count($categories)-1)]['id'],
        

    ];
});
