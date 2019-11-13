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
            @endforeach
        </ul>
    </div>
@endif
   <form action="/admin/categories" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug">
        </div>

        <div class="form-group">
            <label for="parentCategory">Parent Category</label>

           <select name="parentCategory" id="parentCategory" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">
                        {{$category->name}}
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
        <img id="holder" style="margin-top:15px;max-height:100px;">
        <br><br>
        <button class="btn btn-primary">Add Category</button>
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