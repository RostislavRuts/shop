<?php

namespace App\Http\Controllers\Admin;

/*Это контроллер CRUD(create, read, update, delete). 
Он создается по комманде в консоле php artisan make:controller Admin/ProductController --resource.

По сути это контроллер с готовыми методами для чено конкретно каждый метод см.ниже. В маршрутном файле resources/web.php для такого контроллера есть спец маршрут см.web.php*/

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
/*С помощью этих комманд мы связываем контроллер с моделями. 
Модели в свою очередб имеют связь с БД. Таким образом мы можем получать данные из таблиц в БД в контроллере чрез модель */

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//Этот метод возвращает представления со всеми категориями
    {
        $products = Product::all();
        /*где Product:: - класс Модели Product.php,
        all() - всторенная ф-ция получения данных таблицы в БД*/

        // Product::all() - является статической ф-цией

        /*dump($products) - это встроенная ф-ция для того чтоб просмотреть получаемые данные,
         то есть ф-ция вывода данных в виде коллекции(коллекция это что то типа массива),
        где каждый элемент этого массива является свойством класса МОДЕЛИ;*/
        $title = 'Products';
        return view('admin.products.index', compact('products', 'title'));
        /*Если мы хотим что то показать то нужно исспользовать
            ф-цию view() - ф-ция laravel выводит на экран представление(то что будет отображаться).

            Представления создаються и храняться в папке resources/views/... 
            ТУТ в ф-ции view() 
            в превом параметре говорится о том что в этом проэкте есть папка resources/views/admin/products c файлом index.blade.php и мы ее выводим на экран ('admin.products.index'). 

            Во втором параметре ф-ции view() мы перечисляем переменные которые будем исспользовать в представлении, а ф-ция compact() помогает нам передать переменные в виде ассоциотивного массива compact('products', 'title')*/

           /* После всего переходим в представление которое связано с этим методом контроллера а именно resources/views/admin/products/index.blade.php*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $title = 'Add Product';
        return view('admin.products.create', compact('categories', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        //dd($request->сategory);
        $request->validate([
            'name'=>'required|min:3',
            'price'=>'required|numeric',
            'description'=>'required',
            'quantity'=>'required',
            'recommended'=>'required',

        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->img = $request->filepath;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->recommended = $request->recommended == 1 ? 1 : 0;
        $product->category_id = $request->сategory;
        /*для картинок подклюсили менеджер для работы с файлами и в create.blade создали div в нем есть инпут name="filepath" с него приходит путь к картинке!*/
        $product->save();
        return redirect('/admin/products');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //Задачи этого метода:
        // 1. получаем данные редакируемого продукта с помощью $id
        //2. Этот метод возвращает представления с формой редактирования продуктов. 
        /*3. В файле resources/views/admin/products/edit.blade.php в форме action="/products" method="put". Далее данные из этой формы попадают в метод update см. public function update(Request $request, $id)*/
        $product = Product::find($id);
        $categories = Category::all();
        $title = 'Edit product';
        return view('admin.products.edit', compact('product', 'title', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|min:3',
            'price'=>'required|numeric',
            'description'=>'required',
            'quantity'=>'required',
            'recommended'=>'required',

        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->img = $request->filepath;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->recommended = $request->recommended == 1 ? 1 : 0;
        $product->category_id = $request->сategory;
        
        /*для картинок подклюсили менеджер для работы с файлами и в create.blade создали div в нем есть инпут name="filepath" с него приходит путь к картинке!*/
        $product->save();
        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //С помощью модели связанной с этим контроллером удаляет продукт из БД по $id. Заканчиваеться редиректом
        $product = Product::find($id);
        $product->delete(); 
        return redirect('/admin/products');
    }

    public function editRecommended(Request $request)
    /*Этот метод работает с ajax для галочки в колонке. Сам js отвечает за front и там все норм при клике на галочку она меняет цвет с синего на серый и наоборот.
        Но помимо этого нам нужно перезаписывать в
    таблице products в БД значения в колонке recommended. Для этого и пишем эту ф-цию(метод)*/
    {
        //dump($request);
        $product = Product::find($request->id);
        $product->recommended = $product->recommended==1 ? 0 : 1;
        echo $product->save();
    }
}
