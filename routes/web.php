<?php

Route::get('/phpinfo', function () {
    phpinfo();
});
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
| User route
|--------------------------------------------------------------------------
*/
    Route::get('/user/profile', 'User\ProfileController@index');
    Route::post('/user/profile/update', 'User\ProfileController@update')->name('user.profile.update');

/*
|--------------------------------------------------------------------------
| Library route
|--------------------------------------------------------------------------
*/
    Route::group(['middleware' => ['auth'], 'namespace' => 'Library', 'prefix' => 'library'], function () {
        Route::get('/', 'LibraryController@index');
        Route::get('/create', 'LibraryController@create');
        Route::get('/{id}', 'LibraryController@show');
        Route::get('/image/{name}', 'LibraryController@getImage');
        Route::get('/file/{name}', 'LibraryController@getFile');

        Route::post('/{id}/author/update', 'LibraryController@authorUpdate')->name('library.author.update');
        Route::post('/upload/image', 'LibraryController@image');
        Route::post('/store', 'LibraryController@store')->name('library.store');
    });

/*
|--------------------------------------------------------------------------
| Tag route
|--------------------------------------------------------------------------
*/
    Route::group(['middleware' => ['auth'], 'namespace' => 'Tag', 'prefix' => 'tag'], function () {
        Route::get('/', 'TagController@index');
        Route::get('/create', 'TagController@create');
        Route::get('/json', 'TagController@json');

        Route::post('/{id}/delete', 'TagController@delete')->name('tag.delete');
        Route::post('/store', 'TagController@store')->name('tag.store');
    });

/*
|--------------------------------------------------------------------------
| Top-Manager CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator',
        'prefix' => 'top-manager',
        'namespace' => 'TopManager'
    ], function () {
        Route::get('/', 'TopManagerController@index');
        Route::get('/create', 'TopManagerController@create');
        Route::post('/store', 'TopManagerController@store')->name('top-manager.store');
    });

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
        Route::post('/{id}/update', 'StudentController@update')->name('student.update');
    });

/*
|--------------------------------------------------------------------------
| Team CRUD route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager|manager|teacher|student',
        'prefix' => 'team',
        'namespace' => 'Team'
    ], function () {
        Route::get('/', 'TeamController@index');
        Route::get('/create', 'TeamController@create');
        Route::get('/template', 'Template\TemplateController@index');
        Route::get('/template/create', 'Template\TemplateController@create');
        Route::get('/template/{name}/edit', 'Template\TemplateController@edit');
        Route::get('/{name}', 'TeamController@show');
        Route::get('/{name}/students', 'Student\StudentController@index');
        Route::get('/{name}/teachers', 'Teacher\TeacherController@index');
        Route::get('/{name}/schedule', 'Schedule\ScheduleController@index');
        Route::get('/{name}/schedule/create', 'Schedule\ScheduleController@create');
        Route::get('/{name}/homework', 'HomeWork\HomeWorkController@index');
        Route::get('/{name}/homework/{discipline}', 'HomeWork\HomeWorkController@show');
        Route::get('/{name}/homework/{discipline}/create', 'HomeWork\HomeWorkController@create');
        Route::get('/{name}/homework/{discipline}/file/{file}', 'HomeWork\HomeWorkController@file')->name('team.homework.file');
        Route::get('/{name}/homework/{discipline}/{homework}', 'HomeWork\HomeWorkController@homework');
        Route::get('/{name}/homework/{discipline}/{homework}/solution/edit', 'HomeWork\SolutionController@edit');

        Route::post('/{name}/update', 'TeamController@update')->name('team.update');
        Route::post('/{name}/homework/{homework}/delete', 'HomeWork\HomeWorkController@delete')->name('team.homework.delete');
        Route::post('/{name}/homework/{discipline}/store', 'HomeWork\HomeWorkController@store')->name('team.homework.store');
        Route::post('/{name}/homework/{discipline}/{homework}/update', 'HomeWork\HomeWorkController@update')->name('team.homework.update');
        Route::post('/{name}/homework/{discipline}/{homework}/solution/update', 'HomeWork\SolutionController@update')->name('team.homework.solution.update');
        Route::post('/{name}/homework/{discipline}/{homework}', 'HomeWork\HomeWorkController@solution')->name('team.homework.solution');
        Route::post('/{name}/schedule/store', 'Schedule\ScheduleController@store')->name('team.schedule.store');
        Route::post('/{name}/schedule/{id}/delete', 'Schedule\ScheduleController@delete')->name('team.schedule.delete');
        Route::post('/template/store', 'Template\TemplateController@store')->name('team.template.store');
        Route::post('/store', 'TeamController@store')->name('team.store');
        Route::post('/{name}/student/{studentId}/delete', 'TeamController@studentDelete')->name('team.student.delete');
        Route::post('/{name}/student/store', 'StoreController@student')->name('team.student.store');
        Route::post('/{name}/teacher/store', 'StoreController@teacher')->name('team.teacher.store');
        Route::post('/template/{name}/teacher/store', 'Template\TemplateController@teacher')->name('team.template.teacher.store');
        Route::post('/template/{teamId}/teacher/{disciplineId}/delete', 'Template\TemplateController@disciplineDelete')->name('team.template.discipline.delete');
    });

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
        Route::get('/{id}', 'TeacherController@show');

        Route::post('/store', 'TeacherController@store')->name('teacher.store');
        Route::post('/{id}/update', 'TeacherController@update')->name('teacher.update');
        Route::post('/{id}/discipline/store', 'DisciplineController@store')->name('teacher.discipline.store');
    });

/*
|--------------------------------------------------------------------------
| News Social route
|--------------------------------------------------------------------------
*/
    Route::post('/social/{socialId}/delete', 'Social\SocialController@delete')->name('social.delete');
    Route::post('/social/{userId}/store', 'Social\SocialController@store')->name('social.store');

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

Route::post('/avatar/{studentId}/update', 'Store\AvatarController@update')->name('avatar.update');