<?php

/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['guest'], 'namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::get('/auth/token', 'TokenController@index');
    Route::post('/auth/token', 'TokenController@token')->name('auth.token');
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
| Manager CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager',
        'prefix' => 'manager',
        'namespace' => 'Manager'
    ], function () {
        Route::get('/', 'ManagerController@index');
        Route::get('/create', 'ManagerController@create');
        Route::post('/store', 'ManagerController@store')->name('manager.store');
    });

/*
|--------------------------------------------------------------------------
| Student CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager|manager',
        'prefix' => 'student',
        'namespace' => 'Student'
    ], function () {
        Route::get('/', 'StudentController@index');
        Route::get('/create', 'StudentController@create');
        Route::get('/{id}', 'StudentController@show');
        Route::post('/store', 'StudentController@store')->name('student.store');
    });

/*
|--------------------------------------------------------------------------
| Team CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager|manager',
        'prefix' => 'team',
        'namespace' => 'Team'
    ], function () {
        Route::get('/', 'TeamController@index');
        Route::get('/create', 'TeamController@create');
        Route::get('/{name}/edit', 'TeamController@edit');
        Route::post('/store', 'TeamController@store')->name('team.store');
        Route::post('/{name}/member/store', 'MemberController@store')->name('team.member.store');
    });
    Route::get('/team/{name}', 'Team\TeamController@show');

/*
|--------------------------------------------------------------------------
| Discipline CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager|manager',
        'prefix' => 'discipline',
        'namespace' => 'Discipline'
    ], function () {
        Route::get('/', 'DisciplineController@index');
        Route::get('/create', 'DisciplineController@create');
        Route::get('/{name}/edit', 'DisciplineController@edit');
        Route::post('/store', 'DisciplineController@store')->name('discipline.store');
        Route::post('/{name}/update', 'DisciplineController@update')->name('discipline.update');
    });

/*
|--------------------------------------------------------------------------
| Teacher CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager|manager',
        'prefix' => 'teacher',
        'namespace' => 'Teacher'
    ], function () {
        Route::get('/', 'TeacherController@index');
        Route::get('/create', 'TeacherController@create');
        Route::get('/{name}/edit', 'TeacherController@edit');
        Route::post('/store', 'TeacherController@store')->name('teacher.store');
        Route::post('/{id}/update', 'TeacherController@update')->name('teacher.update');
        Route::post('/{id}/discipline/store', 'DisciplineController@store')->name('teacher.discipline.store');
    });
    Route::get('/teacher/{id}', 'Teacher\TeacherController@show');

/*
|--------------------------------------------------------------------------
| News CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager|manager',
        'prefix' => 'news',
        'namespace' => 'News'
    ], function () {
        Route::get('/create', 'NewsController@create');
        Route::post('/store', 'NewsController@store')->name('news.store');
    });
    Route::get('/news', 'News\NewsController@index');
    Route::get('/news/{id}', 'News\NewsController@show');

/*
|--------------------------------------------------------------------------
| Store avatar|image etc
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'auth',
        'prefix' => 'store',
        'namespace' => 'Store'
    ], function () {
        Route::post('/avatar', 'AvatarController@store')->name('store.avatar');
    });