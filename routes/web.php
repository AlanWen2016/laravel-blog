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

    $password = encrypt(1234);
    var_dump($password);
    echo '<br>';
    var_dump(decrypt($password));
    die();
    return json_encode([1234]);
});


Route::group(['namespace'=>'User', 'prefix' => 'user/'], function (){
    Route::get('info', ['as' => 'user', 'uses' => 'UserController@index']);
});
//Auth::routes();


//Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
//Route::get('user/login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('/home', 'HomeController@index')->name('home');


// 非脚手架路由
Route::group([ 'namespace' => 'App\Http\Controllers\User', 'middleware' => ''], function () {
    Route::get('/qq/login', 'LoginController@qqLoginCallback');
    Route::get('/qq/login/url', 'LoginController@qqLoginUrl');
    Route::get('/user/logout', 'LoginController@logout');
    Route::post('/user/login', 'LoginController@login');
});

