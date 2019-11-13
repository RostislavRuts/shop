@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Checkout</h1>
	<h2>Cart</h2>

	@include('product.minicart')

	<hr style="border: 1px solid maroon;">
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<form action="/buy" method="post">
		@csrf
		<input type="hidden" name="user_id" value="{{ Auth::user()->id ?? '' }}">
		<div class="form-group">
			<label for="name">Name: </label>
			<input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name ?? '' }}">
		</div>

		<div class="form-group">
			<label for="email">Email: </label>
			<input type="text" name="email" id="email" class="form-control" value="{{ Auth::user()->email ?? '' }}">
		</div>

		<div class="form-group">
			<label for="phone">Phone: </label>
			<input type="text" name="phone" id="phone" class="form-control">
		</div>

		<div class="form-group">
			<label for="address">Address: </label>
			<textarea name="address" id="address" class="form-control"></textarea>
		</div>

		<button class="btn btn-success">Buy</button>
	</form>
</div>
@endsection