<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    public function status()
    {
    	return $this->belongsTo('App\Status');
    }

    public function getCreatedAtAttribute($value)
    {
    	//в параметре приходит то что написано в БД
    	return Carbon::parse($value)->format('d.m.Y H:i');
    }

    public function items()
    {
    	return $this->hasMany('App\OrderItems', 'order_id');
    }
}
