<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    public $timestamps = true;
    public $primaryKey ='id';

    protected $fillable = [
        'user_name',
        'user_photo',
        'title',
        'news_photo',
        'content',
    ];
}
