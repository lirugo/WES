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
    |--------------------------------------------------------------------------
    | Manager route
    |--------------------------------------------------------------------------
    |--------------------------------------------------------------------------
    */
        /*
        |--------------------------------------------------------------------------
        | Student route
        |--------------------------------------------------------------------------
        */
        Route::group(['middleware' => ['auth'], 'prefix' => 'manage/manager/student', 'namespace' => 'Manage\Manager\Student'], function () {
            Route::get('/create', 'StudentController@create');
            Route::post('/store', 'StudentController@store')->name('manage.manager.student.store');
        });