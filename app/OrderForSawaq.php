<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderForSawaq extends Model
{
    //
    protected $table='order_for_sawaq';
    protected $fillable=[
        'user_id',
        'order_id',
        'status',
    ];
}
