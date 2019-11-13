<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Sale;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $recommended = Product::recommended()
        ->WithImage()
        ->orderBy('created_at', 'DESC')
        ->paginate(12);
        $sale = Sale::all();
        return view('home', compact('recommended', 'sale'));
        //database/querybuilder
    }

    public function showProduct($slug)
    {
        $product = Product::where('slug', $slug)
                    ->first();
        //dump($product);

        return view('product.show', compact('product'));
    }
}
