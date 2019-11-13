<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sale;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();
        $title = 'Our sales';
        return view('admin.sales.index', compact('sales', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Sale';
        return view('admin.sales.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3|unique:sales,name',
            'sum'=>'required|numeric',
        ]);

        $sale = new Sale();
        $sale->name = $request->name;
        $sale->sum = $request->sum;
        $sale->save();
        return redirect('/admin/sales');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Задачи этого метода:
        // 1. получаем данные редакируемого продукта с помощью $id
        //2. Этот метод возвращает представления с формой редактирования продуктов. 
        /*3. В файле resources/views/admin/products/edit.blade.php в форме action="/products" method="put". Далее данные из этой формы попадают в метод update см. public function update(Request $request, $id)*/
        $sale = Sale::find($id);
        $title = 'Edit sale';
        return view('admin.sales.edit', compact('sale', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|min:3',
            'sum'=>'required|numeric',
        ]);

        $sale = Sale::find($id);
        $sale->name = $request->name;
        $sale->sum = $request->sum;
        $sale->save();
        return redirect('/admin/sales');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //С помощью модели связанной с этим контроллером удаляет продукт из БД по $id. Заканчиваеться редиректом
        $sale = Sale::find($id);
        $sale->delete(); 
        return redirect('/admin/sales');
    }
}
