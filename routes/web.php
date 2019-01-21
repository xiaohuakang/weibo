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

// 首页
Route::get('/', 'StaticPagesController@home')->name('home');
// 帮助页
Route::get('/help', 'StaticPagesController@help')->name('help');
// 关于页
Route::get('/about', 'StaticPagesController@about')->name('about');

// 用户注册页
Route::get('signup', 'UsersController@create')->name('signup');

// 用户处理路由
Route::resource('users', 'UsersController');


// 用户登录页
Route::get('login', 'SessionsController@create')->name('login');
// 提交用户登录信息
Route::post('login', 'SessionsController@store')->name('login');
// 用户退出
Route::delete('logout', 'SessionsController@destroy')->name('logout');


// 激活邮箱
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
