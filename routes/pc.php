<?php

// 首页
Route::get('/', 'WebController@index');
// 登录
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// 注册
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// 忘记密码
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// 找回密码
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// 游记
Route::resource('home/travel', 'TravelController')->names('home.travel');
// 会员中心
Route::redirect('home', 'home/travel')->name('home');
Route::view('home/setting', 'www.home.setting')->name('home.setting')->middleware('auth');
Route::view('home/message', 'www.home.message')->name('home.message')->middleware('auth');
Route::get('home/order', 'HomeController@order')->name('home.order');
Route::get('home/order/{order}/show', 'HomeController@orderInfo')->name('home.order.show');
Route::view('home/order/info', 'www.home.order_info')->name('home.order.info')->middleware('auth');
// 定制游
Route::view('customized', 'www.customized');
// 活动
Route::get('activity/show/{activity}', 'ShowController@activity')->name('www.activity.show');
Route::get('activity/list', 'ListController@activity')->name('www.activity.list');
// 攻略
Route::get('raider/show/{raider}', 'ShowController@raider')->name('www.raider.show');
Route::get('raider/list', 'ListController@raiders')->name('www.raider.list');
// 领队
Route::get('leader/show/{leader}', 'ShowController@leader')->name('www.leader.show');
Route::get('leader/list/{province?}', 'ListController@leaders')->name('www.leader.list');
// 游记
Route::get('travel/show/{travel}', 'ShowController@travel')->name('www.travel.show');
Route::get('travel/list', 'ListController@travel')->name('www.travel.list');
// 用户的游记列表
Route::get('travel/list/{user}', 'ListController@userTravel')->name('www.user.travel');
// 视频
Route::get('video/show/{video}', 'ShowController@video')->name('www.video.show');
Route::get('video/list', 'ListController@video')->name('www.video.list');
// 文章
Route::get('article/show/{article}', 'ShowController@article')->name('www.article.show');
// 搜索
Route::get('search', 'ListController@search')->name('search');
// 报名页面
Route::get('tuan/{tuan}', 'PayController@create')->name('pay.order.create');
// 显示二维码的支付页面和支付结果
Route::get('order/{order}/pay', 'PayController@showQrcode')->name('order.qrcode');