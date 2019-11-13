@if(session('cart'))
	<div class="minicart">
		@foreach(session('cart') as $item)
			<br>
			<div class="row product" data-id="{{$item['id']}}">
				<div class="col-md-4">
					<img src="{{$item['img']}}" alt="" class="img-fluid">
				</div>

				<div class="col-md-6">
					{{$item['name']}}
					<br>
					Price: {{$item['qty']}} x {{$item['price']}}
				</div>

				<div class="col-md-2">
					<i class="fa fa-2x fa-trash text-danger remove-product" data-toggle="tooltip" data-placement="top" title="delete product"></i>
				</div>
			</div>
		@endforeach
		<br>
		<div class="row">
			<div class="col">
				@if(session('totalSum'))
					@if(session('totalSum')['sum'] != session('totalSum')['finalSum'])
						
						<b>Общая сумма: {{session('totalSum')['sum']}} грн</b>
						<ul class="list-group">
							  @foreach(session('totalSum')['description'] as $value)
								@if($value != null)
									<li class="list-group-item list-group-item-success">{!! $value !!}</li>	
								@endif
							@endforeach 
						</ul>

						<b>Сумма со скидкой: {{session('totalSum')['finalSum']}} грн</b>
						
					@else
						<b>Общая сумма: {{session('totalSum')['sum']}} грн</b>
					@endif				 	
				@endif
			</div>
		</div>
	</div>
@else
	<p>Your cart is empty</p>
@endif