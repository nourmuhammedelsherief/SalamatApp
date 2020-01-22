<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table='orders';
    protected $fillable=[
        'status',
        'start',
        'end',
        'current_lat',
        'current_long',
        'target_lat',
        'target_long',
        'user_id',
        'sawaq_user_id',
        'price',
        'cancel',
        'end_at',
        'service_type',
        'car_type',
        'car_status',
        'size',
        'car_photo',
    ];
}
