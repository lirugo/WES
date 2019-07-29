<?php

// Manage
    Breadcrumbs::for('manage', function ($trail) {
        $trail->push(@trans('breadcrumbs.Manage Panel'), url('/manage'));
    });

// Chat
    Breadcrumbs::for('chat', function ($trail) {
        $trail->push(@trans('breadcrumbs.Chat'), url('/chat'));
    });

//Change log
    Breadcrumbs::for('changelog', function ($trail) {
        $trail->push(@trans('breadcrumbs.Change Log'), url('/changelog'));
    });
    Breadcrumbs::for('changelog-create', function ($trail) {
        $trail->parent('changelog');
        $trail->push(@trans('breadcrumbs.Create'), url('/chnagelog/create'));
    });
//Change log
    Breadcrumbs::for('notifications', function ($trail) {
        $trail->push(@trans('breadcrumbs.Notifications'), url('/notification'));
    });

//Tags
    Breadcrumbs::for('tag', function ($trail) {
        $trail->push(@trans('breadcrumbs.Tags'), url('/tag'));
    });
    Breadcrumbs::for('tag-create', function ($trail) {
        $trail->parent('tag');
        $trail->push(@trans('breadcrumbs.Create'), url('/tag/create'));
    });

//Library
    Breadcrumbs::for('library', function ($trail) {
        $trail->push(@trans('breadcrumbs.Library'), url('/library'));
    });
    Breadcrumbs::for('library-show', function ($trail, $library) {
        $trail->parent('library');
        $trail->push($library->title, url('/library/'.$library->id));
    });
    Breadcrumbs::for('library-create', function ($trail) {
        $trail->parent('library');
        $trail->push(@trans('breadcrumbs.Create'), url('/library/create'));
    });

// User
    Breadcrumbs::for('user', function ($trail) {
        $trail->push(@trans('breadcrumbs.User'), url('#'));
    });
    Breadcrumbs::for('user-profile', function ($trail) {
        $trail->parent('user');
        $trail->push(@trans('breadcrumbs.Profile'), url('/user/profile'));
    });
    Breadcrumbs::for('user-settings', function ($trail) {
        $trail->parent('user');
        $trail->push(@trans('breadcrumbs.Settings'), url('/user/settings'));
    });

// News
    Breadcrumbs::for('news', function ($trail) {
        $trail->push(@trans('breadcrumbs.News'), url('/news'));
    });
    Breadcrumbs::for('news-create', function ($trail) {
        $trail->parent('news');
        $trail->push(@trans('breadcrumbs.Create'), url('/news/create'));
    });

// Teacher
    Breadcrumbs::for('teacher', function ($trail) {
        $trail->push(@trans('breadcrumbs.Teachers'), url('/teacher'));
    });
    Breadcrumbs::for('teacher-create', function ($trail) {
        $trail->parent('teacher');
        $trail->push(@trans('breadcrumbs.Create'), url('/teacher/create'));
    });
    Breadcrumbs::for('teacher-show', function ($trail, $teacher) {
        $trail->parent('teacher');
        $trail->push($teacher->getShortName().' - ', url('/teacher/'.$teacher->id.'/show'));
    });

// Student
    Breadcrumbs::for('student', function ($trail) {
        $trail->push(@trans('breadcrumbs.Students'), url('/student'));
    });
    Breadcrumbs::for('student-create', function ($trail) {
        $trail->parent('student');
        $trail->push(@trans('breadcrumbs.Create'), url('/student/create'));
    });
    Breadcrumbs::for('student-show', function ($trail, $student) {
        $trail->parent('student');
        $trail->push($student->getShortName().' - ', url('/student/'.$student->id.'/show'));
    });

// Discipline
    Breadcrumbs::for('discipline', function ($trail) {
        $trail->push(@trans('breadcrumbs.Disciplines'), url('/discipline'));
    });
    Breadcrumbs::for('discipline-create', function ($trail) {
        $trail->parent('discipline');
        $trail->push(@trans('breadcrumbs.Create'), url('/discipline/create'));
    });
    Breadcrumbs::for('discipline-edit', function ($trail, $discipline) {
        $trail->parent('discipline');
        $trail->push($discipline->display_name.' - ', url('/discipline/'.$discipline->id.'/edit'));
    });
    Breadcrumbs::for('discipline-show', function ($trail, $discipline) {
        $trail->parent('discipline');
        $trail->push($discipline->display_name.' - ', url('/discipline/'.$discipline->id.'/show'));
    });

// Team
    Breadcrumbs::for('team', function ($trail) {
        $trail->push(@trans('breadcrumbs.Groups'), url('/team'));
    });

    Breadcrumbs::for('team-common-file-create', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Common File Create'), url('/team/'.$team->name));
    });
    Breadcrumbs::for('team-create', function ($trail) {
        $trail->parent('team');
        $trail->push(@trans('breadcrumbs.Create'), url('/team/create'));
    });
    Breadcrumbs::for('team-show', function ($trail, $team) {
        $trail->parent('team');
        $trail->push($team->display_name, url('/team/'.$team->name));
    });
    Breadcrumbs::for('team-show-setting', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Setting'), url('/team/'.$team->name));
    });
    Breadcrumbs::for('team-teachers', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Teachers'), url('/team/'.$team->name.'/teachers'));
    });
    Breadcrumbs::for('team-students', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Students'), url('/team/'.$team->name.'/students'));
    });

    //Group Work
    Breadcrumbs::for('team-group-work', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Group Work'), url('/team/'.$team->name.'/group-work'));
    });
    Breadcrumbs::for('team-group-work-show', function ($trail, $team, $discipline) {
        $trail->parent('team-group-work', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/group-work/'.$discipline->name));
    });
    Breadcrumbs::for('team-group-work-show-sub-teams', function ($trail, $team, $discipline, $groupWork) {
        $trail->parent('team-group-work-show', $team, $discipline);
        $trail->push(@trans('breadcrumbs.Teams'), url('/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id));
    });
    Breadcrumbs::for('team-group-work-show-sub-teams-sub-team', function ($trail, $team, $discipline, $groupWork, $subTeam) {
        $trail->parent('team-group-work-show-sub-teams', $team, $discipline, $groupWork);
        $trail->push(@trans('breadcrumbs.Team'), url('/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id.'/'.$subTeam->id));
    });

//Courses
    Breadcrumbs::for('team-courses', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.All Courses'), url('/team/'.$team->name.'/courses'));
    });
    Breadcrumbs::for('team-courses-course', function ($trail, $team, $discipline) {
        $trail->parent('team-courses', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/courses/'.$discipline->name));
    });

//Activity
    Breadcrumbs::for('team-activity', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Activity'), url('/team/'.$team->name.'/activity'));
    });
    Breadcrumbs::for('team-activity-show', function ($trail, $team, $discipline) {
        $trail->parent('team-activity', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/activity/'.$discipline->name));
    });
    Breadcrumbs::for('team-activity-create', function ($trail, $team) {
        $trail->parent('team-activity', $team);
        $trail->push(@trans('breadcrumbs.Create'), url('/team/'.$team->name.'/activity/create'));
    });
    Breadcrumbs::for('team-activity-pass', function ($trail, $team, $discipline, $activity) {
        $trail->parent('team-activity-show', $team, $discipline);
        $trail->push($activity->getType(), url('/team/'.$team->name.'/activity/'.$discipline->name.'/pass/',$activity->id));
    });
    //Pretest
    Breadcrumbs::for('team-pretest', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Test'), url('/team/'.$team->name.'/pretest'));
    });
    Breadcrumbs::for('team-material', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Materials'), url('/team/'.$team->name.'/material'));
    });
    Breadcrumbs::for('team-pretest-discipline', function ($trail, $team, $discipline) {
        $trail->parent('team-pretest', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name));
    });
    Breadcrumbs::for('team-pretest-create', function ($trail, $team) {
        $trail->parent('team-pretest', $team);
        $trail->push(@trans('breadcrumbs.Create'), url('/team/'.$team->name.'/pretest/create'));
    });
    Breadcrumbs::for('team-material-create', function ($trail, $team, $dicpline) {
        $trail->parent('team-material-discipline', $team, $dicpline);
        $trail->push(@trans('breadcrumbs.Create'), url('/team/'.$team->name.'/material/create'));
    });
    Breadcrumbs::for('team-material-discipline', function ($trail, $team, $discpline) {
        $trail->parent('team-material', $team);
        $trail->push($discpline->display_name, url('/team/'.$team->name.'/material/'.$discpline->name));
    });
    Breadcrumbs::for('team-material-category-create', function ($trail, $team, $discpline) {
        $trail->parent('team-material-discipline', $team, $discpline);
        $trail->push(@trans('breadcrumbs.Create Category'), url('/team/'.$team->name.'/material/'.$discpline->name.'/category/create'));
    });
    Breadcrumbs::for('team-material-show', function ($trail, $team) {
        $trail->parent('team-material', $team);
        $trail->push(@trans('breadcrumbs.Show'), url('/team/'.$team->name.'/material/show'));
    });
    Breadcrumbs::for('team-pretest-discipline-show', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline', $team, $discipline);
        $trail->push($pretest->name, url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id));
    });
    Breadcrumbs::for('team-pretest-discipline-show-statistic', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline-show', $team, $discipline, $pretest);
        $trail->push(@trans('breadcrumbs.Statistics'), url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id));
    });
    Breadcrumbs::for('team-pretest-discipline-show-access', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline-show', $team, $discipline, $pretest);
        $trail->push(@trans('breadcrumbs.Access'), url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id));
    });
    Breadcrumbs::for('team-pretest-discipline-show-pass', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline-show', $team, $discipline, $pretest);
        $trail->push(@trans('breadcrumbs.Passing test'), url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/'));
    });

    //Mark
    Breadcrumbs::for('team-mark', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Marks'), url('/team/'.$team->name.'/mark'));
    });
    Breadcrumbs::for('team-mark-student', function ($trail, $team, $student) {
        $trail->parent('team-mark', $team);
        $trail->push($student->getShortName(), url('/team/'.$team->name.'/mark/student/'.$student->id));
    });
    Breadcrumbs::for('team-mark-discipline', function ($trail, $team, $discipline) {
        $trail->parent('team-mark', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/mark/'.$discipline->name));
    });
    Breadcrumbs::for('team-mark-discipline-task-create', function ($trail, $team, $discipline) {
        $trail->parent('team-mark-discipline', $team, $discipline);
        $trail->push(@trans('breadcrumbs.Create Task'), url('/team/'.$team->name.'/mark/'.$discipline->name.'/task/create'));
    });

    //Template
        Breadcrumbs::for('team-template', function ($trail) {
            $trail->push(@trans('breadcrumbs.Group Templates'), url('/team/template'));
        });
        Breadcrumbs::for('team-template-create', function ($trail) {
            $trail->parent('team-template');
            $trail->push(@trans('breadcrumbs.Create'), url('/team/template/create'));
        });
        Breadcrumbs::for('team-template-edit', function ($trail, $template) {
            $trail->parent('team-template');
            $trail->push($template->display_name, url('/team/template/'.$template->name.'/edit'));
        });
    //Homework
        Breadcrumbs::for('team-show-homework', function ($trail, $team) {
            $trail->parent('team-show', $team);
            $trail->push(@trans('breadcrumbs.Home Work'), url('/team/'.$team->name.'/homework'));
        });
        Breadcrumbs::for('team-show-homework-discipline', function ($trail, $team, $discipline) {
            $trail->parent('team-show-homework', $team);
            $trail->push($discipline->display_name, url('/team/'.$team->name.'/homework/'.$discipline->name));
        });
        Breadcrumbs::for('team-show-homework-discipline-create', function ($trail, $team, $discipline) {
            $trail->parent('team-show-homework-discipline', $team, $discipline);
            $trail->push(@trans('breadcrumbs.Create'), url('/team/'.$team->name.'/homework/'.$discipline->name.'/create'));
        });
        Breadcrumbs::for('team-show-homework-discipline-homework', function ($trail, $team, $discipline, $homeWork) {
            $trail->parent('team-show-homework-discipline', $team, $discipline);
            $trail->push($homeWork->display_name, url('/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name));
        });
        Breadcrumbs::for('team-show-homework-discipline-homework-edit', function ($trail, $team, $discipline, $homeWork) {
            $trail->parent('team-show-homework-discipline-homework', $team, $discipline, $homeWork);
            $trail->push(@trans('breadcrumbs.Edit'), url('/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name.'/edit'));
        });
    //Schedule
    Breadcrumbs::for('team-show-schedule', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push(@trans('breadcrumbs.Schedule'), url('/team/'.$team->name.'/schedule'));
    });
    Breadcrumbs::for('team-show-schedule-create', function ($trail, $team) {
        $trail->parent('team-show-schedule', $team);
        $trail->push(@trans('breadcrumbs.Create'), url('/team/'.$team->name.'/schedule/create'));
    });



/*
|--------------------------------------------------------------------------
| Top Manager Breadcrumbs
|--------------------------------------------------------------------------
*/
Breadcrumbs::for('top-manager', function ($trail) {
    $trail->push(@trans('breadcrumbs.Top Managers'), url('/top-manager'));
});

Breadcrumbs::for('top-manager-create', function ($trail) {
    $trail->parent('top-manager');
    $trail->push(@trans('breadcrumbs.Create'), url('/top-manager/create'));
});

/*
|--------------------------------------------------------------------------
| Manager Breadcrumbs
|--------------------------------------------------------------------------
*/
Breadcrumbs::for('manager', function ($trail) {
    $trail->push(@trans('breadcrumbs.Managers'), url('/manager'));
});

Breadcrumbs::for('manager-create', function ($trail) {
    $trail->parent('manager');
    $trail->push(@trans('breadcrumbs.Create'), url('/manager/create'));
});

/*
|--------------------------------------------------------------------------
| Student Breadcrumbs
|--------------------------------------------------------------------------
*/
    Breadcrumbs::for('student-team-dashboard', function ($trail, $team) {
        $trail->parent('manage');
        $trail->push($team->display_name.' - Dashboard', url('/manage/student/team/'.$team->name));
    });
    Breadcrumbs::for('student-team-schedule', function ($trail, $team) {
        $trail->parent('student-team-dashboard', $team);
        $trail->push(@trans('breadcrumbs.Schedule'), url('/manage/student/team/'.$team->name));
    });
    Breadcrumbs::for('student-team-teachers', function ($trail, $team) {
        $trail->parent('student-team-dashboard', $team);
        $trail->push(@trans('breadcrumbs.Teachers'), url('/manage/student/team/'.$team->name.'/teachers'));
    });
    Breadcrumbs::for('student-team-homework', function ($trail, $team) {
        $trail->parent('student-team-dashboard', $team);
        $trail->push(@trans('breadcrumbs.Home Work'), url('/manage/student/team/'.$team->name.'/homework'));
    });
    Breadcrumbs::for('student-team-homework-discipline', function ($trail, $team, $discipline) {
        $trail->parent('student-team-homework', $team);
        $trail->push($discipline->display_name, url('/manage/student/team/'.$team->name.'/homework/'.$discipline->name));
    });
    Breadcrumbs::for('student-team-homework-discipline-homework', function ($trail, $team, $discipline, $homeWork) {
        $trail->parent('student-team-homework-discipline', $team, $discipline);
        $trail->push($homeWork->name, url('/manage/student/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name));
    });