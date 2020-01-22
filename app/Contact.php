<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    public $timestamps = true;
    public $primaryKey = 'id';

    protected $fillable = [
        'name',
        'phone',
        'photo',
    ];
}
