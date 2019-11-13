<h1>{{$order->id}}</h1>

<div class="minicart">
		@foreach(session('cart') as $item)
			<br>
			<div class="row product" data-id="{{$item['id']}}">
				<div class="col-md-4">
					<img src="{{$item['img']}}" alt="" class="img-fluid">
				</div>

				<div class="col-md-6">
					<strong>{{$item['name']}}</strong>
					<br>
					<div>Price: {{$item['qty']}} x {{$item['price']}}</div>
				</div>
			</div>
		@endforeach

		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-6">
				@if(session('totalSum'))
					<b>Total Sum: </b> {{session('totalSum')}}
				@endif
			</div>
		</div>
	</div>