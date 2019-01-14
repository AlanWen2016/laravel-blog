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
    return json_encode([1234]);
});

// 无权限接口
Route::group(['namespace'=>'User'], function (){
    Route::get('/user/login', 'LoginController@login');
    Route::post('/user/register', 'RegisterController@register');
    Route::get('/qq/login', 'LoginController@qqLoginCallback');
    Route::get('/qq/login/url', 'LoginController@qqLoginUrl');
    Route::get('/user/logout', 'LoginController@logout');
    Route::post('/user/login', 'LoginController@login');
});


// 需要登陆校验接口
Route::group(['namespace'=>'User', 'middleware' => ['Verification']], function (){
    Route::get('user/info', ['as' => 'user', 'uses' => 'UserController@index']);
});


Route::group(['namespace'=>'Blog', 'prefix'=> 'blog','middleware' => ['Verification']], function (){
    Route::post('/saveBlog', 'BlogController@saveBlog');
});



Route::group(['namespace' => 'Blog'],function (){
    Route::get('blog/list', 'BlogController@getBlogs');
    Route::get('blog/info', 'BlogController@blogInfo');
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


Route::get('/guzzle/get', 'TestController@getGuzzle');
Route::get('/test', 'TestController@test');
