{{-- Эта страница с формой создания категорий которые потом попадет в БД в таблицу users, а так же отобразятся в нашем представлении по адрессу resources/views/admin/users/create.blade.php в котором есть кнопка-ссылка которая нас и перебрасывает по URL-адрессу этой страницы

Так же она связана с методом create, create, store контроллера UserController --}}

@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                {{-- 1. Мы делали проверку(валидацию) в методе который связан с этим представлением (UserController@create). 
                  Если при проверке возникает ошибка то браузер нам об этом скажет в нежелательном для нас виде так ка он не откроет представление.

                  2. Чтобы увидеть ошибки в том виде как нам нравится нужно исспользовать данную проверку(это встроенная проверка laravel) см.ниже. Она выведет div с перечнем ошибок на экран в читабельном виде.

                  3. Подробнее про нее на сайте laravel/the basics/validation/# Displaying the validations errors*/ --}}
            @endforeach
        </ul>
    </div>
@endif
   <form action="/admin/categories/{{$category->id}}" method="post">
        @csrf
        @method('put')
        {{--Всегда исспользовать эту защиту при создании формы!!!!--}}

        {{-- Laravel позволяет легко защитить ваше приложение от атак с подделкой межсайтовых запросов (CSRF). Подделка межсайтовых запросов — тип атаки на сайты, при котором несанкционированные команды выполняются от имени аутентифицированного пользователя.

        Laravel автоматически генерирует CSRF-"токен" для каждой активной пользовательской сессии в приложении. Этот токен используется для проверки того, что именно авторизованный пользователь делает запрос в приложение.

        При определении каждой HTML-формы вы должны включать в неё скрытое поле CSRF-токена, чтобы посредник CSRF-защиты мог проверить запрос. Вы можете использовать вспомогательную функцию csrf_field() для генерирования поля токена:

        PHP
        <form method="POST" action="/profile">
          {{ csrf_field() }}
          ...
    </form> --}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{$category->name}}">
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug">
        </div>

        <div class="form-group">
            <label for="parentCategory">Parent Category</label>

           <select name="parentCategory" id="parentCategory" class="form-control" multiple>
                @foreach($categories as $cat)
                    <option value="{{$cat->id}}">
                        {{$cat->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="input-group">
        <!-- Эту верстку мы взяли на сайте https://unisharp.github.io/laravel-filemanager/installation. -->
           <span class="input-group-btn">
             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
               <i class="fa fa-picture-o"></i> Choose
             </a>
           </span>
           <input id="thumbnail" class="form-control" type="text" name="filepath">
        </div>
        <div class="row">
            <div class="col-md-3" style="text-align: center;">
                @if($category->img)
                <h5>Old picture</h5>
                <img src="{{$category->img}}" alt="" style="margin-top:15px; max-height:100px;">
                @endif
            </div>
            <div class="col-md-3">
                <h5>New picture</h5>
                <img id="holder" style="margin-top:15px; max-height:100px;">
            </div>
            
        </div>
       

        

        <br><br>

        <button class="btn btn-primary">Edit Category</button>
   </form>
@stop

@section('js')
    <script>
        $(document).ready( function () {
            $('#parentCategory').select2();
        } );
         {{-- Этот плагин мы подключили с сайта DataTable. 
        Это наша красивая таблица. В файле config/adminlte.php мы этот плагтн подключили и прописали ссылку на последние версии.
        select2(); - ф-ция которая красиво выводит категории родителей --}}
    </script>
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    {{-- В pakalyst нашли https://unisharp.github.io/laravel-filemanager/installation.
    В файле .env сделали изменения в APP_URL(APP_URL=http://shop).

    В папке config/lfm файл можно почитать и посмотреть настройки этого менеджера. Там же можно менять пути к папкам и их названия(папок в которых будут хранится картинки) --}}
    <script>
        $('#lfm').filemanager('image');
    </script>
@endsection