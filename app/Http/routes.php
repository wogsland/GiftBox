<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() 
{
	return View::make('home');
});

Route::get('/create', function() 
{
	if (!isset($_SESSION['user_id'])) {
		 return Redirect::to('/');
	} else {
		return View::make('create');
	}
});

Route::get('/preview/{id}', function($id) 
{
	$data['id'] = $id;
	return View::make('preview', $data);
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
