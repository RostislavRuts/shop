@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>{{$product->name}}</h1>
		<div class="row">
			<div class="col-md-6">
				<img src="{{$product->img}}" alt="" class="img-fluid">
			</div>

			<div class="col-md-6">
				Price: {{$product->price}}<br>
				@if($product->quantity > 0)
					In stock: {{$product->quantity}}
					<form action="" class="add-to-cart">
						<div class="form-group">
							<label for="qty">Quantity:</label>
							<input type="number" class="form-control" id="qty" name="qty" min="1" max="{{$product->quantity}}" value="1">
						</div>

						<input type="hidden" name="id" value="{{$product->id}}">

						<button class="btn btn-primary btn-block"><i class="fa fa-2x fa-cart-plus" aria-hidden="true" style=""></i>  <span style="font-size: 20px; margin-left: 5px;">Add to Cart</span></button>
					</form>
				@else
					Not available
				@endif
				<br>
				<a href="/" class="btn btn-info">Back to main</a>
			</div>
		</div>
	</div>
@endsection