@extends('layouts.app')

@section('content')
<div class="container">
	<h3>История заказов <ins><b>{{$user->name}}</b></ins></h3>

    @foreach($user->orders as $order)
        <h4><span class="badge badge-secondary">Заказ #{{$order->id}}</span></h4>
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
       
        <h4><span class="badge badge-info">Общая цена: {{$order->total_sum}}</span></h4>

        <hr style="border: 1px solid maroon;">
    @endforeach 
@stop
</div>
    
