<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table='order_items'; //если название таблицы не совпадает с контроллером
    public $timestamps = false;
}
