<?php

Route::post('comm/load_provider', 'Comm@load_provider');
Route::post('comm/load_group', 'Comm@load_group');

Route::get('login', 'Auth@loginForm')->name('login_form');
Route::post('login', 'Auth@login')->name('login');
Route::post('forget-password', 'Auth@forgetPassword')->name("forget_password");

Route::get('logout', 'Auth@logout')->name('logout');

Route::get('/', 'Dashboard@index')->name('home');

Route::get('tags.json', 'Tag@json');
Route::resource('tag', 'Tag');
Route::post('tag/delete', 'Tag@delete')->name('tag.delete');

//menu
Route::get('menu/get_list_menu', 'Menu@getListMenu');
Route::post('menu/big_sort', 'Menu@bigSort');
Route::get('menu/delete/{id}', 'Menu@delete');
Route::resource('menu', 'Menu');

//quản lý quản trị viên
Route::post('admin/change_status', 'Admin@changeStatus');
Route::post('admin/upload_avatar', 'Admin@uploadAvatar');
Route::get('admin/delete/{id}', 'Admin@delete');

Route::resource('admin', 'Admin');

Route::get('admin_group/delete/{id}', 'AdminGroup@delete')->name('admin_group.delete');
Route::get('admin_group/detail/{id}', 'AdminGroup@detail');
Route::resource('admin_group', 'AdminGroup');

// admin log
Route::get('admin_activity', 'AdminActivity@index')->name('admin_activity.index');
Route::get('admin_activity/show/{id}', 'AdminActivity@show')->name('admin_activity.show');

// system log
Route::get('system_log', 'SystemLog@index')->name('system_log.index');

// my
Route::get('my/change_password', 'My@changePassword')->name('my.change_password');
Route::post('my/do_change_password', 'My@doChangePassword')->name('my.do_change_password');
Route::resource('my', 'My');

//admin_role
Route::post('admin_role/change_status', 'AdminRole@changeStatus');
Route::resource('admin_role', 'AdminRole');

//permission_controller
Route::post('permission_controller/change_status', 'PermissionController@changeStatus');
Route::resource('permission_controller', 'PermissionController');