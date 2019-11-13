<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $title = 'Categories';
        return view('admin.categories.index', compact('categories', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $title = 'Add Categories';
        return view('admin.categories.create', compact('categories', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required:min:3|max:128|unique:categories,name'
            /*unique:categories,name - проверяет на уникальность. categories это название таблицы в которой делается проверка, а name названия столбца*/
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_id = $request->parentCategory == 0 ? null : $request->parentCategory;
        $category->img = $request->filepath;
        /*для картинок подклюсили менеджер для работы с файлами и в create.blade создали div в нем есть инпут name="filepath" с него приходит путь к картинке!*/
        $category->save();
        return redirect('/admin/categories');

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
        // 1. получаем данные редакируемой категории с помощью $id
        //2. Этот метод возвращает представления с формой редактирования категории. 
        /*3. В файле resources/views/admin/users/edit.blade.php в форме action="/category" method="put". Далее данные из этой формы попадают в метод update см. public function update(Request $request, $id)*/
        $category = Category::find($id);
        $categories = Category::all();
        $title = 'Edit Category';
        return view('admin.categories.edit', compact('category', 'title', 'categories'));
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
            'name'=>'required:min:3|max:128|unique:categories,name'
            /*unique:categories,name - проверяет на уникальность. categories это название таблицы в которой делается проверка, а name названия столбца*/
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_id = $request->parentCategory == 0 ? null : $request->parentCategory;
        $category->img = $request->filepath;
        /*для картинок подклюсили менеджер для работы с файлами и в create.blade создали div в нем есть инпут name="filepath" с него приходит путь к картинке!*/
        $category->save();
        return redirect('/admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //С помощью модели связанной с этим контроллером удаляет категорию из БД по $id. Заканчиваеться редиректом
        $category = Category::find($id);
        $category->delete(); 
        return redirect('/admin/categories');
    }
}
