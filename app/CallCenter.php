<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallCenter extends Model
{
    protected $table = 'call_centers';
    public $timestamps = true;
    public $primaryKey = 'id';

    protected $fillable = [
        'name',
        'phone',
        'photo',
    ];
}
