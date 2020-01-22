<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',  'password',
        'phone_number',
        'image',
        'car_image',
        'api_token',
        'multi_place',
        'places',
        'university_drive',
        'employees_drive',
        'active',
        'verification_code',
        'driver_id',
        'nationality_id',
        'age_id',
        'company_id',
        'car_model_id',
        'city_mode_id',
        'passenger_id',
        'city_id',
        'region_id',
        'type',
        'car_number',
        'national_id',
        'status',
        'licence_image',
        'id_image',
        'paper_image',
        'service_type',
        'car_type',
        'other'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
