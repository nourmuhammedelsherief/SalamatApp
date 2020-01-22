<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::group(['middleware' =>  'cors'], function () {
        Route::post( '/register-mobile', [
            'uses' => 'Api\AuthController@registerMobile',
            'as'   => 'register-mobile'
        ] );
        Route::post( '/phone-verification', [
            'uses' => 'Api\AuthController@register_phone_post',
            'as'   => 'register_phone_post'
        ] );
        Route::post( '/resend-code', [
            'uses' => 'Api\AuthController@resend_code',
            'as'   => 'resend_code'
        ] );
        /*user register*/
        Route::post( '/user-register-mobile', [
            'uses' => 'Api\AuthUserController@registerMobile',
            'as'   => 'user-register-mobile'
        ] );
        Route::post( '/user-phone-verification', [
            'uses' => 'Api\AuthUserController@register_phone_post',
            'as'   => 'user-register_phone_post'
        ] );
        Route::post( '/user-resend-code', [
            'uses' => 'Api\AuthUserController@resend_code',
            'as'   => 'user-resend_code'
        ] );
        Route::post( '/user-register', [
            'uses' => 'Api\AuthUserController@register',
            'as'   => 'register'
        ] );
        Route::post( '/user-login', [
            'uses' => 'Api\AuthUserController@login',
            'as'   => 'user-login'
        ] );
        Route::post( '/user-forget-password', [
            'uses' => 'Api\AuthUserController@forgetPassword',
            'as'   => 'forgetPassword'
        ] );
        Route::post( '/user-confirm-reset-code', [
            'uses' => 'Api\AuthUserController@confirmResetCode',
            'as'   => 'user-confirmResetCode'
        ] );
        Route::post( '/user-reset-password', [
            'uses' => 'Api\AuthUserController@resetPassword',
            'as'   => 'user-resetPassword'
        ] );
        /*end user register*/
        Route::get( '/register-data', [
            'uses' => 'Api\AuthController@register_data',
            'as'   => 'register_data'
        ] );
        Route::get( '/region/{id}', [
            'uses' => 'Api\AuthController@get_region',
            'as'   => 'get_region'
        ] );
        Route::post( '/register', [
            'uses' => 'Api\AuthController@register',
            'as'   => 'register'
        ] );
        Route::post( '/login', [
            'uses' => 'Api\AuthController@login',
            'as'   => 'login'
        ] );
        Route::post( '/forget-password', [
            'uses' => 'Api\AuthController@forgetPassword',
            'as'   => 'forgetPassword'
        ] );
        Route::post( '/confirm-reset-code', [
            'uses' => 'Api\AuthController@confirmResetCode',
            'as'   => 'confirmResetCode'
        ] );
        Route::post( '/reset-password', [
            'uses' => 'Api\AuthController@resetPassword',
            'as'   => 'resetPassword'
        ] );

        Route::get( '/terms-and-conditions', [
            'uses' => 'Api\ProfileController@terms_and_conditions',
            'as'   => 'terms_and_conditions'
        ] );
        Route::get( '/about-us', [
            'uses' => 'Api\ProfileController@about_us',
            'as'   => 'about_us'
        ] );
        // =====================================  get contacts =====================
        Route::get('/all_contacts' ,[
            'uses' => 'Api\UserController@all_contacts',
            'as'   => 'all_contacts'
        ]);
        Route::get('/call_center' ,[
            'uses' => 'Api\UserController@call_center',
            'as'   => 'call_center'
        ]);
        // =========================  news ==================
        Route::get('/all_news' ,[
            'uses' => 'Api\UserController@all_news',
            'as'   => 'all_news'
        ]);
        Route::get('/get_news_by_id/{news_id}' ,[
            'uses' => 'Api\UserController@get_news_by_id',
            'as'   => 'get_news_by_id'
        ]);
        // ========================= get Car Types ==============================
        Route::get('/car_types' ,[
            'uses' => 'Api\UserController@car_types',
            'as'   => 'car_types'
        ]);
    });

    Route::get( '/all-school', [
        'uses' => 'Api\DetailsController@school',
        'as'   => 'school'
    ] );

    Route::group(['middleware' => ['auth:api', 'cors']], function () {

        /*notification*/
        Route::get('/list-notifications', 'Api\ApiController@listNotifications');
        Route::post('/delete_Notifications/{id}', 'Api\ApiController@delete_Notifications');

        /*notification*/
        Route::post( '/change-password', [
            'uses' => 'Api\AuthController@changePassword',
            'as'   => 'changePassword'
        ] );
        Route::post( '/change-phone-number', [
            'uses' => 'Api\AuthController@change_phone_number',
            'as'   => 'change_phone_number'
        ] );
        Route::post( '/check-code-change-phone-number', [
            'uses' => 'Api\AuthController@check_code_changeNumber',
            'as'   => 'check_code_changeNumber'
        ] );
        Route::post( '/change-image', [
            'uses' => 'Api\UserController@change_image',
            'as'   => 'change_image'
        ] );
        Route::post( '/complete_register', [
            'uses' => 'Api\UserController@complete_register',
            'as'   => 'complete_register'
        ] );
        Route::post( '/change_car_type', [
            'uses' => 'Api\UserController@change_car_type',
            'as'   => 'change_car_type'
        ] );

        Route::post( '/change_services', [
            'uses' => 'Api\UserController@change_services',
            'as'   => 'change_services'
        ] );

        // sawaq order ============
        Route::get('/sawaq-order', 'Api\SawaqController@my_orders');
        Route::get('/sawaq_waiting_order', 'Api\SawaqController@sawaq_waiting_order');
        Route::get('/sawaq-refuse-order/{id}', 'Api\SawaqController@refuse_order');
        Route::post('/sawaq-send-offer/{id}', 'Api\SawaqController@send_offer');
        Route::get('/commission-status', 'Api\SawaqController@commission_status');
        Route::post('/pay-commission/{id}', 'Api\SawaqController@pay_commission');
        Route::get('/settings', 'Api\DetailsController@settings');
        Route::get('/allOrders', 'Api\OrderController@allOrders');







//    ===========refreshToken ====================

        Route::post('/refresh-device-token', [
            'uses' => 'Api\DetailsController@refreshDeviceToken',
            'as'   => 'refreshDeviceToken'
        ] );
        Route::post('/refreshToken', [
            'uses' => 'Api\DetailsController@refreshToken',
            'as'   => 'refreshToken'
        ] );
        //===============logout========================

        Route::post('/logout', [
            'uses' => 'Api\AuthController@logout',
            'as'   => 'logout'
        ] );






    });


    //======================user app ====================
    Route::group(['middleware' => ['auth:api', 'cors']], function () {

        /*notification*/
        Route::get('/user-list-notifications', 'Api\ApiController@listNotifications');
        Route::post('/user-delete_Notifications/{id}', 'Api\ApiController@delete_Notifications');


        /*notification*/

        // order ============
        Route::post('/order', 'Api\OrderController@order_post');
        Route::post('/user_cancel_order/{order_id}', 'Api\OrderController@user_cancel_order');
        Route::get('/user-accept-offer/{id}', 'Api\OrderController@accept_sawaq_offers_price');
        Route::get('/user-refuse-offer/{id}', 'Api\OrderController@delete_sawaq_offers_price');
        Route::get('/offers', 'Api\ProfileController@sawaq_offers_price');
        Route::get('/get-order', 'Api\ProfileController@order_details');
        Route::get('/get-driver/{id}', 'Api\SawaqController@get_driver');
        Route::get('/get-user/{id}', 'Api\SawaqController@get_user');

        Route::get('/order-details/{id}', 'Api\ProfileController@order_details');
        Route::get('/order-offer/{id}', 'Api\ProfileController@order_offers');
        Route::post('/rate-driver/{id}', 'Api\ProfileController@rate_driver_user');



        //====================user app ====================
        Route::post( '/user-change-password', [
            'uses' => 'Api\AuthUserController@changePassword',
            'as'   => 'user_changePassword'
        ] );

        Route::post( '/user_change_name', [
            'uses' => 'Api\AuthUserController@change_name',
            'as'   => 'user_change_name'
        ] );
        Route::post( '/user-change-phone-number', [
            'uses' => 'Api\AuthUserController@change_phone_number',
            'as'   => 'user_change_phone_number'
        ] );
        Route::post( '/user-check-code-change-phone-number', [
            'uses' => 'Api\AuthUserController@check_code_changeNumber',
            'as'   => 'user_check_code_changeNumber'
        ] );
        Route::post( '/user-change-image', [
            'uses' => 'Api\AuthUserController@change_image',
            'as'   => 'user_change_image'
        ] );
        //===============logout========================

        Route::post('/user-logout', [
            'uses' => 'Api\AuthUserController@logout',
            'as'   => 'user-logout'
        ] );
        Route::post('/change_car_number', [
            'uses' => 'Api\AuthController@change_car_number',
            'as'   => 'change_car_number'
        ] );
        Route::post('/change_car_image', [
            'uses' => 'Api\AuthController@change_car_image',
            'as'   => 'change_car_image'
        ] );

        Route::post('/change_licence_image', [
            'uses' => 'Api\AuthController@change_licence_image',
            'as'   => 'change_licence_image'
        ] );
        Route::post('/change_paper_image', [
            'uses' => 'Api\AuthController@change_paper_image',
            'as'   => 'change_paper_image'
        ] );
        Route::post('/change_id_image', [
            'uses' => 'Api\AuthController@change_id_image',
            'as'   => 'change_id_image'
        ] );
        //=============== Is_online ========//

        route::post('/check_online' , [
            'uses' => 'Api\AuthController@online',
            'as'   => 'check_online'
        ]);

        Route::get( '/get_reasons', [
            'uses' => 'Api\AuthUserController@get_reasons',
            'as'   => 'get_reasons'
        ] );
        Route::post( '/delete_order/{id}', [
            'uses' => 'Api\AuthUserController@delete_order',
            'as'   => 'delete_order'
        ] );
        // ========================== get sawaq orders =============//

        Route::get( '/sawaq_order_1_2', [
            'uses' => 'Api\OrderController@sawaq_order_1_2',
            'as'   => 'sawaq_order_1_2'
        ] );
        Route::get('/sawaq_all_offers_orders' ,[
            'uses' => 'Api\OrderController@sawaq_all_offers_orders',
            'as'   => 'sawaq_all_offers_orders'
        ]);
        Route::post('/report_sawaq/{id}' ,[
            'uses' => 'Api\ProfileController@report_sawaq',
            'as'   => 'report_sawaq'
        ]);


    });


});
