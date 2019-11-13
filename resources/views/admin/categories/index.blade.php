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
    			<th>Slug</th>
    			<th>Img</th>
                <th>Parent Category</th>
                <th style="text-align: center;">Delete Category</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($categories as $category)
    		<tr>
    			<td>{{$loop->iteration}}</td>
    			<td><a href="/admin/categories/{{$category->id}}/edit">{{$category->name}}</a></td>
    			<td>{{$category->slug}}</td>
                <td><img src="{{$category->img}}" alt="" style="width: 50px; height: 50px;"></td>
    			<td>{{$category->parent ? $category->parent->name : ''}}
                    {{-- Прикол этой проверки в том что когда категорий в БД еще нет и мы будем создавать новую(первую) категорию выбьет ошибку. 
                    Для избежания ошибки делаем эту проверку --}}
                </td>
                <td style="text-align: center;">    
                    {{--Это форма для удаления категорий в route:list для метода delete написанно какой URL-адресс нам исспользовать--}}
                    <form action="/admin/categories/{{$category->id}}" method="post">
                        
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
</script>
@endsection