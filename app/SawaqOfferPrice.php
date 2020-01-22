<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SawaqOfferPrice extends Model
{
    //
    protected $table='sawaq_offer_price';
    protected $fillable=[
        'sawaq_user_id',
        'user_id',
        'order_id',
        'price',
        'status',
        'commission',
        'commission_status',
        'end_date',
    ];
    protected $dates = [
        'end_date',
    ];
}
