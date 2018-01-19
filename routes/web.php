<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('teste', function(){
	// $item = App\User::find(1);
	// $item->password = \Illuminate\Support\Facades\Hash::make('mudar123');
	// $item->save();
	exit;
	$item = new App\User();
	$item->name = 'Alfredo Ferrari';
	$item->username = 'af';
	$item->email = 'af@lyfx.co';
	$item->password = Illuminate\Support\Facades\Hash::make('mudar123');
	$item->save();

	// dd($item->toArray());

	echo 'ok';
});

Route::group(['namespace'=>'Admin'], function(){
	Route::get('login', 'UsersController@getLogin')->name('login');
	Route::get('logout', 'UsersController@getLogout');	
	Route::post('login', 'UsersController@postLogin');

	Route::group(['middleware'=>'auth'],function(){
		Route::get('/','DashboardController@index');
		Route::get('/list/{page}','DashboardController@list');
		Route::get('/deleteList/{page}','DashboardController@deleteList');
		Route::get('/export/{page}','DashboardController@export');
		Route::get('/my-account','UsersController@myAccount');
		// Route::get('/debug','DashboardController@fillConsumersAddressData');
	});
});

