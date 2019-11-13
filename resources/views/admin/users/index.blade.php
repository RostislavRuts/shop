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
    			<th>Name</th>
    			<th>Email</th>
    			<th>Role</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($users as $user)
    		<tr>
    			<td>{{$loop->iteration}}</td>
    			<td><a href="/admin/users/{{$user->id}}/edit" class="btn btn-primary">{{$user->name}}</a></td>
    			<td>{{$user->email}}</td>
    			<td>{{$user->roles->pluck('name')->join(', ')}}
                {{-- pluck Метод извлекает все значения для данного ключа в нашем случае обьект user, 
                а с помощью join преобразовали массив в строку и вывели через запятую --}}</td>
                <td>    
                    {{--Это форма для удаления категорий в route:list для метода delete написанно какой URL-адресс нам исспользовать--}}
                    <form action="/admin/users/{{$user->id}}" method="post">
                        
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