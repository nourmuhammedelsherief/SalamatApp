<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportSawa extends Model
{
    protected $table = 'report_sawas';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'report' , 'sawaq_id' , 'user_id'
    ];
}
