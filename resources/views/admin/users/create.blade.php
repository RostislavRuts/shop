{{-- Эта страница с формой создания категорий которые потом попадет в БД в таблицу users, а так же отобразятся в нашем представлении по адрессу resources/views/admin/users/create.blade.php в котором есть кнопка-ссылка которая нас и перебрасывает по URL-адрессу этой страницы

Так же она связана с методом create, create, store контроллера UserController --}}

@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
{{-- 1. Мы делали проверку(валидацию) в методе который связан с этим представлением (UserController@create). 
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

   <form action="/admin/users" method="post">

   		@csrf

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
   			<input type="text" class="form-control" name="name" id="name">
   		</div>

   		<div class="form-group">
   			<label for="email">Email</label>
   			<input type="email" class="form-control" name="email" id="email">
   		</div>

   		<div class="form-group">
   			<label for="password">Password</label>
   			<input type="password" class="form-control" name="password" id="password">
   		</div>

   		<div class="form-group">
   			<label for="repeatPassword">Repeat Password</label>
   			<input type="password" class="form-control" name="repeatPassword" id="repeatPassword">
   		</div>

   		<div class="form-group">
   			<label for="roles">Roles</label>
   			<select name="roles[]" id="roles" class="form-control" multiple>
   				@foreach($roles as $role)
   					<option value="{{$role->id}}">
   						{{$role->name}}
   					</option>
   				@endforeach
   			</select>
   		</div>

   		<button class="btn btn-primary">Save</button>
   </form>
@stop

@section('js')
	<script>
		$(document).ready( function () {
	    	$('#roles').select2();
		} );
	</script>
  {{-- Этот плагин мы подключили с сайта DataTable. 
    Это наша красивая таблица. В файле config/adminlte.php мы этот плагтн подключили и прописали ссылку на последние версии.
    select2(); - ф-ция которая красиво выводит роли --}}
@endsection