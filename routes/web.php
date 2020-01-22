<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    \Illuminate\Support\Facades\Artisan::call('check::commission');
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*admin panel routes*/

Route::get('/admin/home', ['middleware'=> 'auth:admin', 'uses'=>'AdminController\HomeController@index'])->name('admin.home');

Route::prefix('admin')->group(function () {

    Route::get('login', 'AdminController\Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'AdminController\Admin\LoginController@login')->name('admin.login.submit');
    Route::get('password/reset', 'AdminController\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'AdminController\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'AdminController\Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'AdminController\Admin\ResetPasswordController@reset')->name('admin.password.update');
    Route::post('logout', 'AdminController\Admin\LoginController@logout')->name('admin.logout');

    Route::get('get/regions/{id}', 'AdminController\HomeController@get_regions');



    Route::group(['middleware'=> ['web','auth:admin']],function(){

        Route::get('setting','AdminController\SettingController@index');
        Route::post('add/settings','AdminController\SettingController@store');



        Route::get('pages/about','AdminController\PageController@about');
        Route::post('add/pages/about','AdminController\PageController@store_about');


        Route::get('pages/terms','AdminController\PageController@terms');
        Route::post('add/pages/terms','AdminController\PageController@store_terms');


//        ===========================ages===========================================


        Route::get('age','AdminController\AgeController@index');
        Route::get('add/age','AdminController\AgeController@create');
        Route::post('add/age','AdminController\AgeController@store');
        Route::get('edit/age/{id}','AdminController\AgeController@edit');
        Route::post('update/age/{id}','AdminController\AgeController@update');
        Route::get('delete/{id}/age','AdminController\AgeController@destroy');
//     ===================================  contacts  ================================
        Route::get('contacts','AdminController\ContactController@index')->name('Contacts');
        Route::get('contacts/create','AdminController\ContactController@create')->name('createContact');
        Route::post('contacts/store','AdminController\ContactController@store')->name('storeContact');
        Route::get('contacts/edit/{id}','AdminController\ContactController@edit')->name('editContact');
        Route::post('contacts/update/{id}','AdminController\ContactController@update')->name('updateContact');
        Route::get('contacts/delete/{id}','AdminController\ContactController@destroy')->name('deleteContact');


//     ===================================  Call Center ================================
        Route::get('call_center','AdminController\CallCenterController@index')->name('call_center');
        Route::get('call_center/create','AdminController\CallCenterController@create')->name('createCall_center');
        Route::post('call_center/store','AdminController\CallCenterController@store')->name('storeCall_center');
        Route::get('call_center/edit/{id}','AdminController\CallCenterController@edit')->name('editCall_center');
        Route::post('call_center/update/{id}','AdminController\CallCenterController@update')->name('updateCall_center');
        Route::get('call_center/delete/{id}','AdminController\CallCenterController@destroy')->name('deleteCall_center');

//     ===================================  news ================================
        Route::get('news','AdminController\NewsController@index')->name('News');
        Route::get('news/create','AdminController\NewsController@create')->name('createNews');
        Route::post('news/store','AdminController\NewsController@store')->name('storeNews');
        Route::get('news/edit/{id}','AdminController\NewsController@edit')->name('editNews');
        Route::post('news/update/{id}','AdminController\NewsController@update')->name('updateNews');
        Route::get('news/delete/{id}','AdminController\NewsController@destroy')->name('deleteNews');

//     ===================================  car types ================================
        Route::get('car_type','AdminController\CarTypeController@index')->name('CarType');
        Route::get('car_type/create','AdminController\CarTypeController@create')->name('createCarType');
        Route::post('car_type/store','AdminController\CarTypeController@store')->name('storeCarType');
        Route::get('car_type/edit/{id}','AdminController\CarTypeController@edit')->name('editCarType');
        Route::post('car_type/update/{id}','AdminController\CarTypeController@update')->name('updateCarType');
        Route::get('car_type/delete/{id}','AdminController\CarTypeController@destroy')->name('deleteCarType');
//        ===========================all order===========================================

        Route::get('order/student','AdminController\OrderController@student');
        Route::get('order/employee','AdminController\OrderController@employee');
        Route::get('order/rent','AdminController\OrderController@rent');
        Route::get('show/offer/{id}','AdminController\OrderController@offer');
        Route::get('commission','AdminController\OrderController@commission');
        Route::get('edit/commission/{id}','AdminController\OrderController@edit_commission');
        Route::post('update/commission/{id}','AdminController\OrderController@update_commission');



//        ===========================carModel===========================================

        Route::get('carModel','AdminController\carModelController@index');
        Route::get('add/carModel','AdminController\carModelController@create');
        Route::post('add/carModel','AdminController\carModelController@store');
        Route::get('edit/carModel/{id}','AdminController\carModelController@edit');
        Route::post('update/carModel/{id}','AdminController\carModelController@update');
        Route::get('delete/{id}/carModel','AdminController\carModelController@destroy');





//        ===========================company===========================================

        Route::get('company','AdminController\CompanyController@index');
        Route::get('add/company','AdminController\CompanyController@create');
        Route::post('add/company','AdminController\CompanyController@store');
        Route::get('edit/company/{id}','AdminController\CompanyController@edit');
        Route::post('update/company/{id}','AdminController\CompanyController@update');
        Route::get('delete/{id}/company','AdminController\CompanyController@destroy');






//        ===========================driver===========================================

        Route::get('driver','AdminController\DriverController@index');
        Route::get('add/driver','AdminController\DriverController@create');
        Route::post('add/driver','AdminController\DriverController@store');
        Route::get('edit/driver/{id}','AdminController\DriverController@edit');
        Route::post('update/driver/{id}','AdminController\DriverController@update');
        Route::get('delete/{id}/driver','AdminController\DriverController@destroy');



//        ===========================ModelCityController===========================================

        Route::get('modelCity','AdminController\ModelCityController@index');
        Route::get('add/modelCity','AdminController\ModelCityController@create');
        Route::post('add/modelCity','AdminController\ModelCityController@store');
        Route::get('edit/modelCity/{id}','AdminController\ModelCityController@edit');
        Route::post('update/modelCity/{id}','AdminController\ModelCityController@update');
        Route::get('delete/{id}/modelCity','AdminController\ModelCityController@destroy');



//        ===========================nationality===========================================

        Route::get('nationality','AdminController\NationalityController@index');
        Route::get('add/nationality','AdminController\NationalityController@create');
        Route::post('add/nationality','AdminController\NationalityController@store');
        Route::get('edit/nationality/{id}','AdminController\NationalityController@edit');
        Route::post('update/nationality/{id}','AdminController\NationalityController@update');
        Route::get('delete/{id}/nationality','AdminController\NationalityController@destroy');



//        ===========================passenger===========================================

        Route::get('passenger','AdminController\PassengerController@index');
        Route::get('add/passenger','AdminController\PassengerController@create');
        Route::post('add/passenger','AdminController\PassengerController@store');
        Route::get('edit/passenger/{id}','AdminController\PassengerController@edit');
        Route::post('update/passenger/{id}','AdminController\PassengerController@update');
        Route::get('delete/{id}/passenger','AdminController\PassengerController@destroy');


//        ===========================country and cities===========================================
        Route::get('country','AdminController\CountryController@index');
        Route::get('add/country','AdminController\CountryController@create');
        Route::post('add/country','AdminController\CountryController@store');
        Route::get('edit/country/{id}','AdminController\CountryController@edit');
        Route::post('update/country/{id}','AdminController\CountryController@update');
        Route::get('delete/{id}/country','AdminController\CountryController@destroy');



        Route::get('region','AdminController\RegionController@index');
        Route::get('add/region','AdminController\RegionController@create');
        Route::post('add/region','AdminController\RegionController@store');
        Route::get('edit/region/{id}','AdminController\RegionController@edit');
        Route::post('update/region/{id}','AdminController\RegionController@update');
        Route::get('delete/{id}/region','AdminController\RegionController@destroy');


//        ===================================users============================================

        Route::get('user/{id}','AdminController\UserController@index');
        Route::get('add/user/{type}','AdminController\UserController@create');
        Route::post('add/user/{type}','AdminController\UserController@store');
        Route::get('edit/user/{id}/{type}','AdminController\UserController@edit');
        Route::get('edit/userAccount/{id}/{type}','AdminController\UserController@edit_account');
        Route::post('update/userAccount/{id}/{type}','AdminController\UserController@update_account');
        Route::post('update/user/{id}/{type}','AdminController\UserController@update');
        Route::post('update/pass/{id}','AdminController\UserController@update_pass');
        Route::post('update/privacy/{id}','AdminController\UserController@update_privacy');
        Route::get('delete/{id}/user','AdminController\UserController@destroy');
//        ===========================school===========================================

        Route::get('school','AdminController\SchoolController@index');
        Route::get('add/school','AdminController\SchoolController@create');
        Route::post('add/school','AdminController\SchoolController@store');
        Route::get('edit/school/{id}','AdminController\SchoolController@edit');
        Route::post('update/school/{id}','AdminController\SchoolController@update');
        Route::get('delete/{id}/school','AdminController\SchoolController@destroy');

//       ===================== Reasons To Delete Order ==============================
        Route::get('reasons','ResonController@index');
        Route::get('add/reasons','ResonController@create');
        Route::post('add/reasons','ResonController@store');
        Route::get('edit/reasons/{id}','ResonController@edit');
        Route::post('update/reasons/{id}','ResonController@update');
        Route::get('delete/{id}/reasons','ResonController@destroy');

        //       ===================== Reports for drivers ==============================
        Route::get('reports','ReportSawaController@index');
        Route::get('add/reports','ReportSawaController@create');
        Route::post('add/reports','ReportSawaController@store');
        Route::get('edit/reports/{id}','ReportSawaController@edit');
        Route::post('update/reports/{id}','ReportSawaController@update');
        Route::get('delete/{id}/reports','ReportSawaController@destroy');

                //       ===================== CancelOrder for Customers ==============================
        Route::get('CancelOrder','CancelOrder@index');
        Route::get('add/CancelOrder','CancelOrder@create');
        Route::post('add/CancelOrder','CancelOrder@store');
        Route::get('edit/CancelOrder/{id}','CancelOrder@edit');
        Route::post('update/CancelOrder/{id}','CancelOrder@update');
        Route::get('delete/{id}/CancelOrder','CancelOrder@destroy');






        //===============================================================


        // Admins Route
        Route::resource('admins', 'AdminController\AdminController');

        Route::get('/profile', [
            'uses' => 'AdminController\AdminController@my_profile',
            'as' => 'my_profile' // name
        ]);
        Route::post('/profileEdit', [
            'uses' => 'AdminController\AdminController@my_profile_edit',
            'as' => 'my_profile_edit' // name
        ]);
        Route::get('/profileChangePass', [
            'uses' => 'AdminController\AdminController@change_pass',
            'as' => 'change_pass' // name
        ]);
        Route::post('/profileChangePass', [
            'uses' => 'AdminController\AdminController@change_pass_update',
            'as' => 'change_pass' // name
        ]);

        Route::get('/admin_delete/{id}', [
            'uses' => 'AdminController\AdminController@admin_delete',
            'as' => 'admin_delete' // name
        ]);

    });



});
Route::get('/Privacy-Policy' , function ()
{
   return view('admin.privacyAndPolicy');
});
