{{-- Эта страница с формой редактирования продуктов которые потом попадет в БД в таблицу products, а так же отобразятся в нашем представлении по адрессу resources/views/admin/products/edit.blade.php в котором есть кнопка-ссылка которая нас и перебрасывает по URL-адрессу этой страницы

Так же она связана с методом edit, update контроллера ProductController --}}
@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
{{-- 1. Мы делали проверку(валидацию) в методе который связан с этим представлением (ProductController@create). 
  Если при проверке возникает ошибка то браузер нам об этом скажет в нежелательном для нас виде так ка он не откроет представление.

  2. Чтобы увидеть ошибки в том виде как нам нравится нужно исспользовать данную проверку(это встроенная проверка laravel) см.ниже. Она выведет div с перечнем ошибок на экран в читабельном виде.

  3. Подробнее про нее на сайте laravel/the basics/validation/# Displaying the validations errors*/ --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   <form action="/admin/sales/{{$sale->id}}" method="post">
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
        <div class="form-group @error('name') has-error @enderror">
            {{-- Рассмотрели ошибки валидации. И решили подсвечивать наши поля красным если будет ошибка.
            https://adminlte.io/themes/AdminLTE/pages/forms/general.html тут нашли инпут который подсвечивается и проинспектировав его увидели див с классами что нам нужны и скопировали себе --}}
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{$sale->name}}">
             @error('name') 
                <span class="help-block">{{$message}}</span>
            @enderror
            {{-- Из за нашего текстового редактора и всяких ошибок которые появляются если не прошли нашу валидацию страница обновляется и стерает все в полях которые мы заполнили, и чтоб этого не происходило мы созраняем написанное в полях с помощью value="{{old('name')}}"--}}

            {{-- Ниже говорим о том что если есть ошибка то выведем ее в span --}}
        </div>

        <div class="form-group @error('sum') has-error @enderror">
            <label for="sum">Sum</label>
            <input type="text" class="form-control" name="sum" id="sum" value="{{$sale->sum}}">
            @error('sum') 
                <span class="help-block">{{$message}}</span>
            @enderror
        </div>
        
        <button class="btn btn-primary">Edit Sale</button>
   </form>
@stop

