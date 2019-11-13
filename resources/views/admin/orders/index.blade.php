@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
    <table id="table">
    	<thead>
    		<tr>
    			<th>#</th>
                <th>User_id</th>
    			<th>Name</th>  		
    			<th>Email</th>              
                <th>Phone</th>
                <th>Address</th> 
                <th>Total Sum</th>
                <th>Status</th>
                <th>Date</th>
                
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($orders as $order)
        		<tr>
        			<td><a href="/admin/orders/{{$order->id}}" class="btn btn-primary">{{$order->id}}</a></td>
                    <td>{{$order->user_id}}</td>
        			<td>
                        @if($order->user_id)
                        <a href="/admin/users/{{$order->user_id}}/orders">{{$order->name}}</a>
                        @else 
                            {{$order->name}}
                        @endif
                    </td>
                    <td>{{$order->email}}</td>  
                    <td>{{$order->phone}}</td>               
                    <td>{{$order->address}}</td>
                    <td>{{$order->total_sum}}</td>  
                    <td>{{$order->status->name}}</td>
                    <td>{{$order->created_at}}</td>

    		@endforeach
    	</tbody>
    </table>
@stop

@section('js')
<script>
	$(document).ready( function () {
    	$('#table').DataTable();
	} );
    /*Это плагин мы подключили с сайта DataTable. 
    Это наша красивая таблица. В файле config/adminlte.php мы этот плагтн подключили и прописали ссылку на последние версии*/
</script>
@endsection