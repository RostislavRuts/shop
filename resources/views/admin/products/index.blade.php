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
                <th>Price</th>
                <th>Description</th> 
                <th>Quantity</th>
                <th>Recommended</th>
                <th>category_id</th>
                <th>Delete Product</th>
    		</tr>
    	</thead>
    	<tbody>
            {{-- Чтобы исспользовать ajax в продуктах мы в public/js создали файл script-admin.js где и писали ajax-функцию. А само подключение у нас происходит в resources/views/vendor/adminlte/master.blade.php --}}
    		@foreach($products as $product)
        		<tr data-id="{{$product->id}}">
                    {{-- Добавили аттрибут data-id для обращения к этому продукту с помощью ajax --}}
        			<td>{{$loop->iteration}}</td>
        			<td><a href="/admin/products/{{$product->id}}/edit">{{$product->name}}</a></td>
                    <td>{{$product->slug}}</td>  
                    <td>{{$product->img}}</td>               
                    <td>{{$product->price}}</td>
                    <td>{{$product->description}}</td>  
                    <td>{{$product->quantity}}</td>
                    <td><i class="edit-recommended fas fa-chevron-down {{$product->recommended?'text-primary':'text-danger'}}"></i></td>
                    {{-- Это колонка в таблице определяет(рекомендует этот товар). 
                    Тут мы выводим иконку галочку и если true или 1 то она синяя, если нет серая.
                    Класс edit-recommended нужен для обращения к этому продукту в ajax --}}
        			<td>{{$product->category?$product->category->name:''}}</td>
                    {{-- В этой колонке хотим выводить категорию к которой относится это продукт.
                    В тернарнике пишем что если есть у продукта категория то выведи если нет то пустая строка --}}
                    <td>    
                    {{--Это форма для удаления продуктов в route:list для метода delete написанно какой URL-адресс нам исспользовать--}}
                        <form action="/admin/products/{{$product->id}}" method="post">
                            
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