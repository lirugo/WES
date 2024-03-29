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

        // Password Reset Routes...
        Route::get('/reset-password', 'ResetPasswordController@resetPasswordEmailForm');
        Route::get('/reset-password/{token}', 'ResetPasswordController@resetPasswordForm');
        Route::post('/reset-password', 'ResetPasswordController@resetMail');
        Route::post('/reset-password/{token}', 'ResetPasswordController@resetPassword');
    });
    Route::group(['middleware' => ['auth'], 'namespace' => 'Auth'], function () {
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });

/*
|--------------------------------------------------------------------------
| ChangeLog Route
|--------------------------------------------------------------------------
*/
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/changelog', 'ChangeLogController@index');
        Route::get('/changelog/create', 'ChangeLogController@create');
        Route::post('/changelog/store', 'ChangeLogController@store')->name('changelog.store');
    });

/*
|--------------------------------------------------------------------------
| Notification Route
|--------------------------------------------------------------------------
*/
    Route::group(['middleware' => ['auth'], 'namespace' => 'Notification'], function () {
        Route::get('/notification', 'NotificationController@index');
        Route::post('/notification/markall', 'NotificationController@markAll');
        Route::post('/notification/markasread/{id}', 'NotificationController@markasread');
    });

/*
|--------------------------------------------------------------------------
| Chat Route
|--------------------------------------------------------------------------
*/
    Route::group(['middleware' => ['auth'], 'namespace' => 'Chat'], function () {
        Route::get('/chat', 'ChatController@index');
    });

    Route::group(['middleware' => ['auth'], 'namespace' => 'Chat', 'prefix' => '/api/chat'], function () {
        Route::get('/friends', 'ApiController@friends');
        Route::get('/{session}/chats', 'ApiController@chats');

        Route::post('/{session}/clear', 'ApiController@clear');
        Route::post('/{session}/unblock', 'BlockController@unblock');
        Route::post('/{session}/block', 'BlockController@block');
        Route::post('/{session}/read', 'ApiController@read');
        Route::post('/{session}/message', 'ApiController@messageStore');
        Route::post('/session', 'SessionController@store');
    });

/*
|--------------------------------------------------------------------------
| Chat Route (Conversations chat#2)
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth'], 'namespace' => 'Chat'], function () {
    Route::get('/conversations', 'ChatController@conversations');
    Route::get('/conversations/{conversation}', 'ChatController@show');
});

Route::group(['middleware' => ['auth'], 'namespace' => 'API', 'prefix' => 'api'], function () {
    Route::post('/conversations', 'ConversationController@store');
    Route::get('/conversations', 'ConversationController@index');
    Route::get('/conversations/{conversation}', 'ConversationController@show');
    Route::post('/conversations/{conversation}/reply', 'ConversationReplyController@store');
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
Route::group(['middleware' => ['auth'], 'namespace' => 'User', 'prefix' => 'user'], function () {
    //Settings
    Route::get('/settings', 'SettingsController@index');
    Route::post('/settings', 'SettingsController@update');
    //Profile
    Route::get('/profile', 'ProfileController@index');
    Route::post('/file', 'UserFileController@store')->name('user.store.file');
    Route::get('/get-file/{fileId}', 'UserFileController@get')->name('user.get.file');
    Route::delete('/delete-file/{fileId}', 'UserFileController@destroy')->name('user.file.delete');
    Route::post('/profile/update', 'ProfileController@update')->name('user.profile.update');
    Route::post('/profile/setAvatar', 'ProfileController@setAvatar')->name('user.profile.setAvatar');
    Route::post('/profile/resetPassword', 'ProfileController@resetPassword')->name('user.profile.resetPassword');
});

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

        Route::post('/{id}/export', 'StudentController@export')->name('student.export');
        Route::post('/store', 'StudentController@store')->name('student.store');
        Route::post('/{id}/update', 'StudentController@update')->name('student.update');
    });


//Video stream
Route::get('/video-stream/{fileName}', 'Team\VideoLesson\VideoController@streamVideo');
/*
|--------------------------------------------------------------------------
| Team route
|--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'role:administrator|top-manager|manager|teacher|student',
        'prefix' => 'team',
        'namespace' => 'Team'
    ], function () {

        Route::post('/{teamName}/export', 'TeamController@export')->name('team.export');
        Route::post('/{teamName}/export-total', 'TeamController@exportTotal')->name('team.exportTotal');

        //Video lessons
        Route::get('/{teamName}/video-lesson/create', 'VideoLesson\VideoLessonController@create');
        Route::get('/{teamName}/video-lesson', 'VideoLesson\VideoLessonController@disciplines');
        Route::get('/{teamName}/video-lesson/{teamDisciplineId}', 'VideoLesson\VideoLessonController@index');
        Route::post('/{teamName}/video-lesson/store', 'VideoLesson\VideoLessonController@store')->name('team.video-lesson.store');
        Route::delete('/{teamName}/video-lesson/{videoLessonId}/delete', 'VideoLesson\VideoLessonController@delete')->name('team.video-lesson.delete');
        Route::post('/{teamName}/video-lesson/{videoLessonId}/update', 'VideoLesson\VideoLessonController@update')->name('team.video-lesson.update');

        Route::get('/', 'TeamController@index');
        Route::get('/create', 'TeamController@create');
        Route::get('/template', 'Template\TemplateController@index');
        Route::get('/template/create', 'Template\TemplateController@create');
        Route::get('/template/{name}/edit', 'Template\TemplateController@edit');
        Route::get('/{name}', 'TeamController@show');

        //All courses
        Route::get('/{name}/courses', 'CoursesController@disciplines');
        Route::get('/{name}/courses/{discipline}', 'CoursesController@course');

        //Settings
        Route::get('/{name}/setting', 'Setting\SettingController@index');
        Route::post('/{name}/setting/disciplines/update', 'Setting\SettingController@disciplinesUpdate');

        //Common file
        Route::get('/{name}/common/file/create', 'Common\FileController@create');
        Route::get('/{name}/common/file/{file}', 'Common\FileController@getFile');
        Route::delete('/{name}/common/file/{file}', 'Common\FileController@delete');
        Route::post('/{name}/common/file/store', 'Common\FileController@store')->name('team.common.file.store');
        //Marks
        Route::get('/{name}/mark', 'MarkController@index');
        Route::get('/{name}/mark/{discipline}', 'MarkController@discipline');
        Route::get('/{name}/mark/{discipline}/task/create', 'TaskController@create');

        //Pretest
        Route::post('/{name}/discipline/{teamDisciplineId}/disable', 'TeamController@disciplineDisable');
        Route::get('/{name}/material', 'MaterialController@index');
        Route::get('/{name}/material/{discipline}/create', 'MaterialController@create');
        Route::get('/{name}/material/{discipline}/{fileId}/edit', 'MaterialController@edit');
        Route::get('/{name}/material/{discipline}/category/create', 'MaterialController@categoryCreate');
        Route::get('/{name}/material/{discipline}/link/create', 'MaterialController@linkCreate');
        Route::get('/{name}/material/{discipline}/video/create', 'MaterialController@videoCreate');
        Route::get('/{name}/material/{discipline}', 'MaterialController@show');
        Route::get('/{name}/pretest', 'Pretest\PretestController@index');
        Route::get('/{name}/pretest/create', 'Pretest\PretestController@create');
        Route::get('/{name}/pretest/discipline/{discipline}', 'Pretest\PretestController@pretests');
        Route::get('/{name}/pretest/discipline/{discipline}/{pretestId}', 'Pretest\PretestController@show');
        Route::get('/{name}/pretest/discipline/{discipline}/{pretestId}/pass', 'Pretest\PretestController@pass');
        Route::get('/{name}/pretest/discipline/{discipline}/{pretestId}/statistic', 'Pretest\PretestController@statistic');
        Route::get('/{name}/pretest/discipline/{discipline}/{pretestId}/access', 'Pretest\PretestController@access');
        Route::post('/{name}/pretest/discipline/{discipline}/{pretestId}/setAccess', 'Pretest\PretestController@setAccess');
        Route::post('/{name}/setHeadman', 'TeamController@setHeadman')->name('team.setHeadman');
        Route::post('/pretest/getFile/{name}', 'Pretest\PretestController@getFile')->name('team.pretest.getFile');
        Route::post('/material/getFile/{name}', 'MaterialController@getFile')->name('team.material.getFile');
        Route::post('/material/getMaterialFile/{name}', 'MaterialController@getMaterialFile')->name('team.material.getMaterialFile');
        Route::post('/material/delete/{id}', 'MaterialController@delete')->name('team.material.delete');
        Route::post('/link/delete/{id}', 'MaterialController@linkDelete')->name('team.link.delete');
        Route::post('/video/delete/{id}', 'MaterialController@videoDelete')->name('team.video.delete');
        Route::post('/category/delete/{id}', 'MaterialController@categoryDelete')->name('team.category.delete');
        Route::post('/{name}/material/{discipline}/store', 'MaterialController@store')->name('team.material.store');
        Route::post('/{name}/material/{discipline}/{fileId}/update', 'MaterialController@update')->name('team.material.update');
        Route::post('/{name}/material/{discipline}/category/store', 'MaterialController@categoryStore')->name('team.material.category.store');
        Route::post('/{name}/material/{discipline}/link/store', 'MaterialController@linkStore')->name('team.material.link.store');
        Route::post('/{name}/material/{discipline}/video/store', 'MaterialController@videoStore')->name('team.material.video.store');
        Route::post('/{name}/material/store/file', 'MaterialController@storeFile')->name('team.material.store.file');
        Route::post('/{name}/pretest/store', 'Pretest\PretestController@store')->name('team.pretest.store');
        Route::post('/{name}/pretest/store/file', 'Pretest\PretestController@storeFile')->name('team.pretest.store.file');
        Route::post('/{name}/pretest/discipline/{discipline}/{pretestId}/start', 'Pretest\PretestController@startPretest');
        Route::post('/{name}/pretest/discipline/{discipline}/{pretestId}/available', 'Pretest\PretestController@available');

        //Group work
        Route::get('/{name}/group-work', 'GroupWork\GroupWorkController@index');
        Route::get('/{name}/group-work/{discipline}', 'GroupWork\GroupWorkController@show');
        Route::get('/{name}/group-work/{discipline}/{groupWorkId}', 'GroupWork\GroupWorkController@subteams');
        Route::get('/{name}/group-work/{discipline}/{groupWorkId}/delete', 'GroupWork\GroupWorkController@delete');
        Route::get('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}', 'GroupWork\GroupWorkController@showSubTeam');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/updateGroupWork', 'GroupWork\GroupWorkController@updateGroupWork');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/finish', 'GroupWork\GroupWorkController@finishGroupWork')->name('team.group-work.finish');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subteamId}/finish', 'GroupWork\GroupWorkController@finishSubTeam')->name('team.group-work.subteam.finish');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}/setSubTeamDeadline', 'GroupWork\GroupWorkController@setSubTeamDeadline');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}/updateSubTeam', 'GroupWork\GroupWorkController@updateSubTeam');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/storeSubTeam', 'GroupWork\GroupWorkController@storeSubTeam');
        Route::post('/{name}/group-work/{discipline}/store', 'GroupWork\GroupWorkController@store');
        Route::post('/{name}/group-work/store/file', 'GroupWork\GroupWorkController@storeFile');
        Route::post('/group-work/getFile/{name}', 'GroupWork\GroupWorkController@getFile');
        //Group work API
        Route::post('/{name}/group-work/{discipline}/getGroupWorks', 'GroupWork\GroupWorkController@getGroupWorks');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/getSubTeams', 'GroupWork\GroupWorkController@getSubTeams');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}/getMessages', 'GroupWork\GroupWorkController@getMessages');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}/newMessage', 'GroupWork\GroupWorkController@newMessage');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}/removeMember/{memberId}', 'GroupWork\GroupWorkController@removeMember');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}/newSubTeamMember/{memberId}', 'GroupWork\GroupWorkController@newSubTeamMember');
        Route::post('/{name}/group-work/{discipline}/{groupWorkId}/{subTeamId}/subTeamUpdateMark/{memberId}', 'GroupWork\GroupWorkController@subTeamUpdateMark');

        //Activity
        Route::post('/{id}/activity/delete', 'Activity\ActivityController@delete')->name('team.activity.delete');
        Route::get('/{name}/activity', 'Activity\ActivityController@index');
        Route::get('/{name}/activity/create', 'Activity\ActivityController@create');
        Route::get('/{name}/activity/{discipline}', 'Activity\ActivityController@show');
        Route::post('/{name}/activity/{discipline}/pass/{id}/update', 'Activity\ActivityController@update');
        Route::get('/{name}/activity/{discipline}/pass/{id}/students', 'Activity\ActivityController@students');
        Route::get('/{name}/activity/{discipline}/pass/{id}/{studentId?}', 'Activity\ActivityController@pass');
        Route::post('/activity/getFile/{name}', 'Activity\ActivityController@getFile')->name('team.activity.getFile');
        Route::post('/{name}/activity/store', 'Activity\ActivityController@store')->name('team.activity.store');
        Route::post('/{name}/activity/store/file', 'Activity\ActivityController@storeFile')->name('team.activity.store.file');
        Route::post('/{name}/activity/{discipline}/pass/{activityId}/{studentId}', 'Activity\ActivityController@setMark')->name('team.activity.pass.mark');
        //Activity API
        Route::post('/{name}/activity/api/send/{activityId}/{studentId}', 'Activity\ActivityController@send');
        Route::post('/{name}/activity/api/getMessages/{activityId}/{studentId}', 'Activity\ActivityController@getMessages');

        //Pretest API
        Route::put('/{name}/pretest/discipline/{discipline}/{pretestId}/question', 'Pretest\PretestController@putQuestion');
        Route::post('/{name}/pretest/discipline/{discipline}/{pretestId}/getStatistic', 'Pretest\PretestController@getStatistic');
        Route::post('/{name}/pretest/discipline/{discipline}/{pretestId}/checking', 'Pretest\PretestController@checking');
        Route::post('/{name}/pretest/discipline/{discipline}/{pretestId}/question', 'Pretest\PretestController@getQuestion');
        Route::delete('/{name}/pretest/discipline/{discipline}/{pretestId}/question/{questionId}', 'Pretest\PretestController@deleteQuestion');
        Route::put('/{name}/pretest/discipline/{discipline}/{pretestId}/update}', 'Pretest\PretestController@update')->name('team.pretest.update');
        Route::put('/{name}/pretest/discipline/{discipline}/{pretestId}/updateEndDate}', 'Pretest\PretestController@updateEndDate')->name('team.pretest.updateEndDate');
        Route::delete('/{name}/pretest/discipline/{discipline}/{pretestId}/delete}', 'Pretest\PretestController@delete')->name('team.pretest.delete');

        Route::get('/{name}/students', 'Student\StudentController@index');
        Route::get('/{name}/teachers', 'Teacher\TeacherController@index');
        Route::get('/{name}/schedule', 'Schedule\ScheduleController@index');
        Route::get('/{name}/schedule/pdf', 'Schedule\ScheduleController@pdf');
        Route::get('/{name}/schedule/create', 'Schedule\ScheduleController@create');
        Route::get('/{name}/homework', 'HomeWork\HomeWorkController@index');
        Route::get('/{name}/homework/{discipline}', 'HomeWork\HomeWorkController@show');
        Route::get('/{name}/homework/{discipline}/create', 'HomeWork\HomeWorkController@create');
        Route::get('/{name}/homework/{discipline}/file/{file}/{homework}', 'HomeWork\HomeWorkController@file')->name('team.homework.file');
        Route::get('/{name}/homework/{discipline}/{homework}', 'HomeWork\HomeWorkController@homework');
        Route::get('/{name}/homework/{discipline}/{homework}/solution/edit', 'HomeWork\SolutionController@edit');

        Route::post('/{name}/mark/{discipline}/task/store', 'TaskController@store')->name('team.mark.discipline.task.store');
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
        Route::post('/{name}/discipline/store', 'StoreController@discipline')->name('team.discipline.store');
        Route::post('/{name}/teacher/store', 'StoreController@teacher')->name('team.teacher.store');
        Route::post('/template/{name}/teacher/store', 'Template\TemplateController@teacher')->name('team.template.teacher.store');
        Route::post('/template/{teamId}/teacher/{disciplineId}/delete', 'Template\TemplateController@disciplineDelete')->name('team.template.discipline.delete');


        //NEW UPDATE API
        Route::post('/api/updateActivityMark', 'TeamApiController@updateActivityMark');
        Route::post('/api/updatePretestMark', 'TeamApiController@updatePretestMark');
        Route::post('/api/updateGroupWorkMark', 'TeamApiController@updateGroupWorkMark');
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

Route::post('/feedback/send', 'FeedbackController@send')->name('feedback.send');

Route::get('/test-video', 'VideoController@streamVideo');

/*
|--------------------------------------------------------------------------
| Team API
|--------------------------------------------------------------------------
*/
