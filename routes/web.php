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
//    $password = encrypt(1234);
//    var_dump($password);
//    echo '<br>';
//    var_dump(decrypt($password));
//    die()

//
//    // 指定一个默认值...
//    $value = session('key', 'default');

    // 在 Session 中存储一条数据...
//    session(['key' => 'value']);
    //    $value = session('key');

    dd(session('key'));
    return json_encode([1234]);
});





Route::group(['namespace'=>'User', 'prefix' => 'user/', 'middleware'=>['web', 'verification']], function (){
    Route::get('info', ['as' => 'user', 'uses' => 'UserController@index']);
    Route::post('register', 'RegisterController@register');
    Route::get('qq/login', 'LoginController@qqLoginCallback');
    Route::get('qq/login/url', 'LoginController@qqLoginUrl');
    Route::get('logout', 'LoginController@logout');
    Route::post('login', 'LoginController@login');
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





