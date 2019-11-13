<?php

namespace App\Http\Controllers\Admin;

/*Это контроллер CRUD(create, read, update, delete). 
Он создается по комманде в консоле php artisan make:controller Admin/UserController --resource.

По сути это контроллер с готовыми методами для чено конкретно каждый метод см.ниже. В маршрутном файле resources/web.php для такого контроллера есть спец маршрут см.web.php*/

use Illuminate\Http\Request;
use Route;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;

/*С помощью этих комманд мы связываем контроллер с моделями. 
Модели в свою очередб имеют связь с БД. Таким образом мы можем получать данные из таблиц в БД в контроллере чрез модель */

use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//Этот метод возвращает представления со всеми категориями
    {
         /*где User:: - класс Модели User.php,
        all() - всторенная ф-ция получения данных таблицы в БД*/

        // User::all() - является статической ф-цией

        /*dump($users) - это встроенная ф-ция для того чтоб просмотреть получаемые данные,
         то есть ф-ция вывода данных в виде коллекции(коллекция это что то типа массива),
        где каждый элемент этого массива является свойством класса МОДЕЛИ;*/
        $users = User::all();
        $title = 'Users';
        return view('admin.users.index', compact('users', 'title'));
        /*Если мы хотим что то показать то нужно исспользовать
            ф-цию view() - ф-ция laravel выводит на экран представление(то что будет отображаться).

            Представления создаються и храняться в папке resources/views/... 
            ТУТ в ф-ции view() 
            в превом параметре говорится о том что в этом проэкте есть папка resources/views/admin/users c файлом index.blade.php и мы ее выводим на экран ('admin.users.index'). 

            Во втором параметре ф-ции view() мы перечисляем переменные которые будем исспользовать в представлении, а ф-ция compact() помогает нам передать переменные в виде ассоциотивного массива compact('user', 'title')*/

           /* После всего переходим в представление которое связано с этим методом контроллера а именно resources/views/admin/users/index.blade.php*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//Этот метод возвращает представления с формой создания категории. В форме action="/category" method="post". Что писать в view(), что писать в маршруте и т.д. можно посмотреть по комманде route:list
    {
        $roles = Role::all();
        //Так как мы подключили модель Role.php получили доступ к таблице roles  в БД. 
        $title = 'Add user';
        return view('admin.users.create', compact('roles', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Задачи этого метода это 
        1. получить данные из формы создания 
        2. записать их в БД
        3. Должен заканчиваться redirect на все категории.
        */

        /*В данном примере все данные которые приходят из формы reources/views/admin/users/create.blade.php попадают в ф-цию(метод контроллера) как параметр в обьект класса Request. А именна полей(элементов) формы <input name='name'> являются свойтвами этого обьекта, которые мы и возвращаем и выводим через представление и маршрут по указанному в них адрессу. 
        Типа этого return $request->name*/

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
            'repeatPassword'=>'same:password',
        ]);

        /*тут проверяется(валидируется) что приходит из формы через параметр этого метода ((Request $request))(это встроенная проверка laravel), где
        'name' => 'required|unique:categories,name|max:100'
        1. required - 
        2. unique:categories,name - говорит о том что именна должны быть уникальными а categories это название таблицы.
        3. max:100 - кол-во допустимых символов
        Все это можно посмотреть на сайте laravel/the basics/validation*/

        /*При этом если проверка валидации не выполняется то следующий код не выполняется.

        А сама ошибка и то как мы ее выводи м есть в create.blade.php*/

        $user = new User();
        /*Так как мы создаем ноаого пользователя на странице create.blade.php, это делается с помощью ООП. 
        Поэтому new User() это обьект, саойства которого это название столбцоа таблицы с БД в нашем случае таблица users*/
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        /*Так как это пароль мы не можем исспользовать его в открытом виде. 
        Его нужно шифровать, и для этого исспользуем Hash::make($request->password)
        
        */
        $user->save();
       /* Из за того что нам нужно присвоить роль пользователю через связанную третью таблицу roles
         мы полбзователя сначала созраняем и таким образом у 
         нового пользователя появляется свое id в таблице в БД. 
        Теперь можем синхронизировать его...*/
        $user->roles()->sync($request->roles);//исспользуется для синхронизации отношений многие ко многим в третьих таблицах
        return redirect('/admin/users');

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
        $user = User::find($id);
        $roles = Role::all();
        $title = 'Edit User';
        return view('admin.users.edit', compact('user', 'title', 'roles'));
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
        /*Этот метод перезаписует(обновляет) данные которые попадают из формы редактирования(с помощью обьекта Request $request) в БД. Какую именно категорию мы перезаписываем мы понимаем с помощью второго параметра матеда $id.*/

         /*Этод метод должен заканчиваться redirect'ом на все категории*/
       $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'sometimes|nullable|min:8',
            'repeatPassword'=>'same:password',
        ]);// тут проверяется что приходит из формы(это встроенная проверка laravel)

        $user = User::find($id);
        /*Тут мы исспользуем модель(обьект) user и вызываем встроенную laravel статическую ф-цию ::find($id) которая ищет по $id категорию которую нам нужно в БД в таблице categories.*/
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }//DyFphNSR4d0xiNe5u
        
        /*Так как это пароль мы не можем исспользовать его в открытом виде. 
        Его нужно шифровать, и для этого исспользуем Hash::make($request->password)
        
        */
        $user->save();
       /* Из за того что нам нужно присвоить роль пользователю через связанную третью таблицу roles
         мы полбзователя сначала созраняем и таким образом у 
         нового пользователя появляется свое id в таблице в БД. 
        Теперь можем синхронизировать его...*/
        $user->roles()->sync($request->roles);//исспользуется для синхронизации отношений многие ко многим в третьих таблицах
        return redirect('/admin/users');
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
        $user = User::find($id);
        $user->delete(); 
        return redirect('/admin/users');
    }

    public function userOrders($id)
    {
        $user = User::find($id);
        $title = 'Orders story';
       // $name = Route::getName();
        /*$name = Route::currentRouteName();
        dd(route('orderHistory', $id));*/

       

        //https://laravel.com/api/5.8/Illuminate/Routing/Route.html

        if($user->isAdmin()){
            if(!request()->is('admin/*')){
                return view('userOrders', compact('user', 'title'));
            } else {
                return view('admin.orders.userOrders', compact('user', 'title'));
            }  
        }
        else {
            return view('userOrders', compact('user', 'title'));
        }
        //dd($user->isAdmin());
        
    }
}
