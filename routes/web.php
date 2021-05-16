<?php

// トップ
Route::get('/', function () {
    if (session('login')) {
        return redirect('room');
    } else {
        return view('index');
    }
});

// ログイン
Route::get('login', 'LoginController@index')->middleware('login_auth');
Route::post('login', 'LoginController@login')->middleware('login_auth');
Route::get('guestlogin', 'LoginController@guestLogin')->middleware('login_auth');
Route::get('logout', 'LoginController@logout');
Route::get('password_reset', 'LoginController@passwordReset')->middleware('login_auth');
Route::post('password_reset', 'LoginController@sendMail')->middleware('login_auth');

// ユーザー
Route::get('user/new', 'UserController@new')->middleware('login_auth');
Route::post('user/new', 'UserController@create')->middleware('login_auth');
Route::get('user/{user_id}/follower', 'UserController@getFollower')->middleware('login_auth');
Route::post('user/follow', 'UserController@follow')->middleware('login_auth');
Route::post('user/unfollow', 'UserController@unFollow')->middleware('login_auth');
Route::get('user/{user_id}', 'UserController@show')->middleware('login_auth');
Route::get('user/{user_id}/edit', 'UserController@edit')->middleware('login_auth');
Route::post('user/{user_id}', 'UserController@update')->middleware('login_auth');

// ルーム
Route::get('room', 'RoomController@index')->middleware('login_auth');
Route::get('followRoom', 'RoomController@followRoom')->middleware('login_auth');
Route::get('room/new', 'RoomController@new')->middleware('login_auth');
Route::post('room', 'RoomController@create')->middleware('login_auth');
Route::get('room/{room_id}', 'RoomController@show')->middleware('login_auth');
Route::post('room/{user_id}/delete', 'RoomController@delete')->middleware('login_auth');
Route::get('room/{room_id}/edit', 'RoomController@edit')->middleware('login_auth');
Route::post('room/{user_id}', 'RoomController@update')->middleware('login_auth');
Route::get('room/{room_id}/get', 'RoomController@get')->middleware('login_auth');
Route::post('room/{room_id}/send', 'RoomController@send')->middleware('login_auth');