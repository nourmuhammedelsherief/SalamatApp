<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected  $table = 'car_types';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

}
