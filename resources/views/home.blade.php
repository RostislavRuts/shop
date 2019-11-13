@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('message'))
        <div class="alert alert-success">                   
            {{session('message')}}
        </div>
        
    @endif
    @if($recommended->count() > 3)
        <section>
            <div class="row">
                <div class="col">
                    <h3>Наши акции: </h3>
                    <ul class="list-group list-group-horizontal-lg">
                      <li class="list-group-item">При покупке первый раз вы получаете скидку 10грн</li>
                      <li class="list-group-item">Пенсионерам скидка 5%</li>
                      <li class="list-group-item">Скидка составит 100грн при оформлении заказа на сумму свыше 1000грн</li>
                    </ul>
                </div>
            </div>

            <br>

            <h2>Рекоменодованные товары</h2>
            
            <div class="owl-carousel owl-theme">
              @foreach($recommended as $product)
                <div class="item">
                    <a href="/product/{{$product->slug}}" class="btn">
                        <div class="name text-center">{{$product->name}}</div>
                        <img src="{{$product->img}}" alt="">
                        <div class="price text-center">{{$product->price}}</div>
                    </a> 
                </div>
              @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
