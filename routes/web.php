<?php

/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['guest'], 'namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login')->name('login');
});
Route::group(['middleware' => ['auth'], 'namespace' => 'Auth'], function () {
    Route::post('/logout', 'LoginController@logout')->name('logout');
});


/*
|--------------------------------------------------------------------------
| Manage panel route
|--------------------------------------------------------------------------
*/
Route::get('/', 'Manage\ManageController@index');
Route::get('/manage', 'Manage\ManageController@index')->name('manage');

/*
|--------------------------------------------------------------------------
| End manage panel route
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Student CRUD route
|--------------------------------------------------------------------------
*/
    Route::group(['middleware' => ['auth'], 'prefix' => 'student', 'namespace' => 'Student'], function () {
        Route::get('/create', 'StudentController@create');
        Route::post('/store', 'StudentController@store')->name('student.store');
    });

/*
|--------------------------------------------------------------------------
| Team CRUD route
|--------------------------------------------------------------------------
*/
    Route::group(['middleware' => ['auth'], 'prefix' => 'team', 'namespace' => 'Team'], function () {
        Route::get('/', 'TeamController@index');
        Route::get('/create', 'TeamController@create');
        Route::get('/{id}', 'TeamController@show');
        Route::get('/{id}/edit', 'TeamController@edit');
        Route::post('/{id}/edit/addMember', 'TeamController@addMember')->name('team.edit.addMember');
        Route::post('/store', 'TeamController@store')->name('team.store');
    });