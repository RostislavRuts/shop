@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
    <table id="table">
    	<thead>
    		<tr>
                <th>id</th>
    			<th>Name</th>
    			<th>Sum</th>
    			
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($sales as $sale)
    		<tr>
                <td>{{$sale->id}}</td>
    			<td><a href="/admin/sales/{{$sale->id}}/edit">{{$sale->name}}</a></td>
    			<td>{{$sale->sum}}</td>
                <td>    
                    {{--Это форма для удаления категорий в route:list для метода delete написанно какой URL-адресс нам исспользовать--}}
                    <form action="/admin/sales/{{$sale->id}}" method="post">
                        
                        @csrf

                        <!-- <input type="hidden" name="_method" value="DELETE"> Это один из способов как исспользовать метод для удаления -->

                        @method('DELETE') {{-- - это второй более короткий вариант для исспользования метода удаления категорий --}}
                        <button class="btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
    		</tr>
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