<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\User;
use App\Order;
use App\OrderItems;
use Mail;
use Auth;


class CartController extends Controller
{
    public function add(Request $request)
    {
    	$product = Product::find($request->id);
    	Cart::addProduct($product, $request->qty);
        return view('product.minicart');

    }

    public function removeAll()
    {
    	Cart::clearCart();
    	return view('product.minicart');
    }

    public function removeProduct(Request $request)
    {
    	Cart::removeCart($request->id);
    	return view('product.minicart');
    }

    public function checkout()
    {
        /*$user = Auth::user()->id;
        dd($user);*/
        return view('checkout');
    }

    public function buy(Request $request)
    {
        $order = new Order();
        $order->user_id = $request->user_id ? $request->user_id : null;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->status_id = 1;//в обработке
        $sum = session('totalSum') ? session('totalSum') : (session('moreTotalSum') ? session('moreTotalSum') : session('FirstTotalSum') ? session('FirstTotalSum') : session('pensiyaTotalSum'));
        $order->total_sum = $sum;
        $order->save();

       // dd($order->user_id);

        foreach (session('cart') as $product) {
           $orderItem = new OrderItems();
           $orderItem->order_id = $order->id;
           $orderItem->product_id = $product['id'];
           $orderItem->product_name = $product['name'];
           $orderItem->product_price = $product['price'];
           $orderItem->product_qty = $product['qty'];
           $orderItem->save();
        }
        //отправить почту админу и заказчику
        /*Mail::send('emails.orderAdmin', compact('order'), function($m) use ($order){
                $m->to('rostislav.ruts@gmail.com')->subject('New order #' . $order->id);
        });//это метод для отправки почты*/
        
        

        Cart::clearCart();

        
        //dispatch - генерирует событие
        
        return redirect('/')->with('message', 'Thank! Your order #' . $order->id);
    }
}
