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

      //OTL
      Route::get('otlupload', ['uses'=>'OtlUploadController@getForm','as'=>'otluploadform','middleware' => ['permission:otl-upload']]);
      Route::post('otlupload', ['uses'=>'OtlUploadController@postForm','middleware' => ['permission:otl-upload']]);

      //User
      //  Main user list
      Route::get('userList', ['uses'=>'UserController@getList','as'=>'userList','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);
      //  user information
      Route::get('user/{n}', ['uses'=>'UserController@show','as'=>'user','middleware' => ['permission:user-view']]);
      //  Create new user
      Route::get('userFormCreate', ['uses'=>'UserController@getFormCreate','as'=>'userFormCreate','middleware' => ['permission:user-create']]);
      Route::post('userFormCreate', ['uses'=>'UserController@postFormCreate','middleware' => ['permission:user-create']]);
      //  Update user
      Route::get('userFormUpdate/{n}', ['uses'=>'UserController@getFormUpdate','as'=>'userFormUpdate','middleware' => ['permission:user-edit']]);
      Route::post('userFormUpdate/{n}', ['uses'=>'UserController@postFormUpdate','middleware' => ['permission:user-edit']]);
      //  Delete user
      Route::get('userDelete/{n}', ['uses'=>'UserController@delete','as'=>'userDelete','middleware' => ['permission:user-delete']]);
      //  user profile
      Route::get('profile/{n}', ['uses'=>'UserController@profile','as'=>'profile']);
      Route::post('passwordUpdate/{n}', ['uses'=>'UserController@passwordUpdate','as'=>'passwordUpdate']);
      //  AJAX
      Route::get('listOfUsersAjax', ['uses'=>'UserController@listOfUsers','as'=>'listOfUsersAjax','middleware' => ['permission:user-view|user-create|user-edit|user-delete']]);

      // Roles
      Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-view|role-create|role-edit|role-delete']]);
      Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show','middleware' => ['permission:role-view']]);
      Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
      Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
      Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show','middleware' => ['permission:role-view']]);
      Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
      Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
      Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

      //Project
      //  Main project list
      Route::get('projectList', ['uses'=>'ProjectController@getList','as'=>'projectList','middleware' => ['permission:project-view|project-create|project-edit|project-delete']]);
      //  project information
      Route::get('project/{n}', ['uses'=>'ProjectController@show','as'=>'project','middleware' => ['permission:project-view']]);
      //  Create new project
      Route::get('projectFormCreate', ['uses'=>'ProjectController@getFormCreate','as'=>'projectFormCreate','middleware' => ['permission:project-create']]);
      Route::post('projectFormCreate', ['uses'=>'ProjectController@postFormCreate','middleware' => ['permission:project-create']]);
      //  Update project
      Route::get('projectFormUpdate/{n}', ['uses'=>'ProjectController@getFormUpdate','as'=>'projectFormUpdate','middleware' => ['permission:project-edit']]);
      Route::post('projectFormUpdate/{n}', ['uses'=>'ProjectController@postFormUpdate','middleware' => ['permission:project-edit']]);
      //  Delete project
      Route::get('projectDelete/{n}', ['uses'=>'ProjectController@delete','as'=>'projectDelete','middleware' => ['permission:project-delete']]);
      //  AJAX
      Route::get('listOfProjectsAjax', ['uses'=>'ProjectController@listOfProjects','as'=>'listOfProjectsAjax','middleware' => ['permission:project-view|project-create|project-edit|project-delete']]);

      //Activity
      //  Main activity list
      Route::get('activityList', ['uses'=>'ActivityController@getList','as'=>'activityList','middleware' => ['permission:activity-view|activity-create|activity-edit|activity-delete']]);
      //  activity information
      Route::get('activity/{n}', ['uses'=>'ActivityController@show','as'=>'activity','middleware' => ['permission:activity-view']]);
      //  Create new activity
      Route::get('activityFormCreate', ['uses'=>'ActivityController@getFormCreate','as'=>'activityFormCreate','middleware' => ['permission:activity-create']]);
      Route::post('activityFormCreate', ['uses'=>'ActivityController@postFormCreate','middleware' => ['permission:activity-create']]);
      //  Update activity
      Route::get('activityFormUpdate/{n}', ['uses'=>'ActivityController@getFormUpdate','as'=>'activityFormUpdate','middleware' => ['permission:activity-edit']]);
      Route::post('activityFormUpdate/{n}', ['uses'=>'ActivityController@postFormUpdate','middleware' => ['permission:activity-edit']]);
      //  Delete activity
      Route::get('activityDelete/{n}', ['uses'=>'ActivityController@delete','as'=>'activityDelete','middleware' => ['permission:activity-delete']]);
      //  AJAX
      Route::get('listOfActivitiesAjax', ['uses'=>'ActivityController@listOfActivities','as'=>'listOfActivitiesAjax','middleware' => ['permission:activity-view|activity-create|activity-edit|activity-delete']]);
      Route::post('listOfActivitiesPerUserAjax', ['uses'=>'ActivityController@listOfActivitiesPerUser','as'=>'listOfActivitiesPerUserAjax','middleware' => ['permission:dashboard-view']]);

      //Dashboards
      Route::get('dashboardActivities', ['uses'=>'DashboardController@activities','as'=>'dashboardActivities','middleware' => ['permission:dashboard-view']]);
      //  Create new activity
      Route::get('dashboardFormCreate/{u}', ['uses'=>'DashboardController@getFormCreate','as'=>'dashboardFormCreate','middleware' => ['permission:dashboard-view']]);
      Route::post('dashboardFormCreate/{u}', ['uses'=>'DashboardController@postFormCreate','middleware' => ['permission:dashboard-view']]);
      //  Update activity
      Route::get('dashboardFormUpdate/{u}/{p}', ['uses'=>'DashboardController@getFormUpdate','as'=>'dashboardFormUpdate','middleware' => ['permission:dashboard-view']]);
      Route::post('dashboardFormUpdate/{u}/{p}', ['uses'=>'DashboardController@postFormUpdate','middleware' => ['permission:dashboard-view']]);


});
