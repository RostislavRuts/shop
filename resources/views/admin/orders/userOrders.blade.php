@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
    <h3>История заказов <ins><b>{{$user->name}}</b></ins></h3>

    @foreach($user->orders as $order)
        <span class="badge badge-secondary" style="font-size: 20px;">Заказ #{{$order->id}}</span>
        <h4>Статус: <b>{{$order->status->name}}</b></h4>
        <h4>Адресс доставки: <b>{{$order->address}}</b></h4>
        <h4>Телефон: <b>{{$order->phone}}</b></h4>

        <br>

        <table class="table">
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
        
        <h4 class="text-white bg-dark">Общая цена: {{$order->total_sum}}</h4>

        <hr style="border: 1px solid maroon;">
    @endforeach 
@stop

@section('js')
<script>
	$(document).ready( function () {
    	$('.table').DataTable();
	} );
    /*Это плагин мы подключили с сайта DataTable. 
    Это наша красивая таблица. В файле config/adminlte.php мы этот плагтн подключили и прописали ссылку на последние версии*/
</script>
@endsection