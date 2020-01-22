<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'user_id', 'type', 'message', 'title','order_id','driver_id'
    ];
}
