<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Session;
/*Подключили сессию так как не будем работать и создавать таблицу в БД.*/
use App\User;
use App\Order;
use App\OrderItems;
use App\Sale;
use Auth;

class Cart
{
    static public function AddProduct($product, $qty)
    {
    	if(Session::get("cart.product_{$product->id}")){
    		$oldQty = Session::get("cart.product_{$product->id}.qty");
    		Session::put("cart.product_{$product->id}.qty", $qty + $oldQty);
    	}
    	else{
    		Session::put("cart.product_{$product->id}.name", $product->name);
	    	Session::put("cart.product_{$product->id}.price", $product->price);
	    	Session::put("cart.product_{$product->id}.img", $product->img);
	    	Session::put("cart.product_{$product->id}.id", $product->id);
	    	Session::put("cart.product_{$product->id}.qty", $qty);
    	}
    	
        self::setTotalSum();
    	
    }

    static public function clearCart($value='')
    {
    	Session::forget('cart');
        Session::forget('totalSum');
    }

    static public function removeCart($id)
    {
    	Session::forget('cart.product_' . $id);
        self::setTotalSum();
    }

    static public function setTotalSum()
    {
        $sum = 0;
        foreach (Session::get("cart") as $product) {

            $sum += $product['qty'] * $product['price'];
        }

        // $arr = ['pensiyaTotalSum'];
     
        // foreach ($arr as $value) {
        //     $sessionObj = Session::get($value);
        //     $sum += $sessionObj['discount'];
        // }
        Session::forget('totalSum');
       
        $discount = array('moreTotalSum'=>0,'pensiyaTotalSum'=>0,'FirstTotalSum'=>0);
        $description = array('FirstTotalSum'=>0, 'moreTotalSum'=>0,'pensiyaTotalSum'=>0);
        $finalSum = $sum;

        if ($sum > 1000) {
            $disc = Sale::find('3')->sum;
            $discount['moreTotalSum'] = $disc;
            $description['moreTotalSum'] = 'Сумма вашей покупки свыше 1000грн. ВЫ получаете скидку: <b><ins>' . $disc . 'грн</b></ins>';
        }
       

        if (Auth::user()) {
            $firstOrder = Order::all()->where('user_id', '=', Auth::user()->id)->count() != 0 ? false : true;

            $pensiya = (Auth::user()->age) >= 65 ? true : false;

            if ($pensiya) {
                $disc = ($sum/100*Sale::find(2)->sum);
                $discount['pensiyaTotalSum'] = $disc;
                $description['pensiyaTotalSum'] = 'Мы всегла внимательно относимся к нашим клиентам. <br>Будучи пенсионером получаете скидку: <b><ins>' . Sale::find(2)->sum . '% от суммы покупки</ins>';
            }
            if ($firstOrder) {
                $disc = Sale::find(1)->sum;
                $discount['FirstTotalSum'] = $disc;
                $description['FirstTotalSum'] = 'Поздравляем с первой покупкой. <br>ВЫ получаете скидку: <b><ins>' . $disc . 'грн</b></ins>'; 
            }
        }
        //dd($description);

        $i = 0;
        foreach ($discount as $value) {
            if($value != 0){
                $finalSum -= $value;
                $i++;
            }
            
            
        }
        //dd($finalSum, $sum);

        $result = array('sum' => $sum, 'finalSum' => $finalSum, 'discount' => $discount, 'description' => $description, 'count' => $i);

        //dd($result);
        Session::put('totalSum', $result);
        // Session::put('discounts', $discount);

        // Session::put('totalSum', $sum);

        /*else if ($sum > 1000){
            Session::put('totalSumX', $sum);
            $sum = $sum - 100 ;
            Session::put('moreTotalSum', $sum);
        }
        else if ($pensiya){
            Session::put('totalSumX', $sum);
            $sum = $sum - ($sum/100*5);
            Session::put('pensiyaTotalSum', $sum);
        }
        else if ($firstOrder){
            Session::put('totalSumX', $sum);
            $sum = $sum - 10;
            Session::put('FirstTotalSum', $sum);
        }*/

    }
}
