<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

/**
* This method is to create an admin once.
* Just run it once, and then remove or comment it out.
**/
Route::get('create',function()
{
	$user = Sentry::getUserProvider()->create(array(
                'email' => 'p_rayees@hotmail.co.uk',
                //password will be hashed upon creation by Sentry 2
                'password' => 'password',
                'first_name' => 'Rayees',
                'last_name' => 'Saidalavi',
                'activated' => 1,
                'permissions' => array ('admin' => 1 )
                ));

	return 'admin created with id of '.$user->id;
});