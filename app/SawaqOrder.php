<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SawaqOrder extends Model
{
    protected $table = 'sawaq_orders';
    public $timestamps = true;
    public $primaryKey = 'id';
    protected $fillable = [
        'sawaq_id' , 'order_id'
    ];
}
