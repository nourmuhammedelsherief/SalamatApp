<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reson extends Model
{
    protected $table='resons';
    public $primaryKey = 'id';
    public $timestamps =true;
    protected $fillable=[
        'reason' , 'user_reason'
    ];
}
