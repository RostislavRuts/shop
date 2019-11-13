<?php
/*php artisan make:seeder ProductsTableSeeder*/
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    //Метод run выполняется, когда мы запускаем механизм посева данных.
    {
        factory(\App\Product::class, 10)->create();
    }
}
