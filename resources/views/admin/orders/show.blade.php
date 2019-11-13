{{-- Эта страница с формой редактирования продуктов которые потом попадет в БД в таблицу products, а так же отобразятся в нашем представлении по адрессу resources/views/admin/products/edit.blade.php в котором есть кнопка-ссылка которая нас и перебрасывает по URL-адрессу этой страницы

Так же она связана с методом edit, update контроллера ProductController --}}
@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
    <h1>Детали заказа #{{$order->id}}</h1>
   <form action="/admin/orders/{{$order->id}}/change-status" method="post">
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
        <div class="form-group" style="width: 20%;">
            <label for="status">Order status</label>

           <select name="status" id="status" class="form-control">
                @foreach($statuses as $status)
                    <option value="{{$status->id}}" {{$order->status_id==$status->id?'selected':''}}>
                        {{$status->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Save new order status</button>
   </form>

   <hr style="border: 1px solid maroon;">

   <table id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product name</th>
                <th>Price</th>
                <th>Quantity</th>     
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->product_price}}</td>
                    <td>{{$product->product_qty}}</td>
            @endforeach
        </tbody>
    </table>
    
    <h4 class="text-danger"><ins>Общая стоимость: <b>{{$order->total_sum}} грн.</b></ins></h4>

@stop

@section('js')
    <script>
        $(document).ready( function () {
            $('#table').DataTable();
            $('#parentCategory').select2();
{{-- Этот плагин мы подключили с сайта DataTable. 
    Это наша красивая таблица. В файле config/adminlte.php мы этот плагтн подключили и прописали ссылку на последние версии.
    select2(); - ф-ция которая красиво выводит статусы --}}
        } );
    </script>
@endsection