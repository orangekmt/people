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


//Auth
// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

// Registration Routes...
// Registration will be deactivated by commenting out the routes
//Route::get('register', 'Auth\AuthController@showRegistrationForm');
//Route::post('register', 'Auth\AuthController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');


// All routes in this function will be protected by user needed to be logged in.
Route::group(['middleware' => ['auth']], function() {
      Route::get('/home', ['uses'=>'HomeController@index','as'=>'home']);

      //User
      //  Main user list
      Route::get('userList', ['uses'=>'UserController@getList','as'=>'userList']);
      //  Create new user
      Route::get('userFormCreate', ['uses'=>'UserController@getFormCreate','as'=>'userFormCreate']);
      Route::post('userFormCreate', ['uses'=>'UserController@postFormCreate']);
      //  Update user
      Route::get('userFormUpdate/{n}', ['uses'=>'UserController@getFormUpdate','as'=>'userFormUpdate']);
      Route::post('userFormUpdate/{n}', ['uses'=>'UserController@postFormUpdate']);
      //  Delete user
      Route::get('userDelete/{n}', ['uses'=>'UserController@delete','as'=>'userDelete']);
      //  user information
      Route::get('user/{n}', ['uses'=>'UserController@show','as'=>'user']);
      //  AJAX
      Route::get('listOfUsersAjax', ['uses'=>'UserController@listOfUsers','as'=>'listOfUsersAjax']);

      // Roles
      Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
      Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
      Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
      Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
      Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
      Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
      Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

});
