<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReason extends Model
{
    protected $table = 'user_reasons';
    public $timestamps = true;
    public $primaryKey = 'id';

    protected $fillable = [
        'reason' , 'user_reason' , 'user_id'
    ];
}
