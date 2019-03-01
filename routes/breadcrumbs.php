<?php

// Manage
    Breadcrumbs::for('manage', function ($trail) {
        $trail->push('Manage', url('/manage'));
    });

//Change log
    Breadcrumbs::for('changelog', function ($trail) {
        $trail->push('Change Log', url('/changelog'));
    });
    Breadcrumbs::for('changelog-create', function ($trail) {
        $trail->parent('changelog');
        $trail->push('Create', url('/chnagelog/create'));
    });

//Tags
    Breadcrumbs::for('tag', function ($trail) {
        $trail->push('Tags', url('/tag'));
    });
    Breadcrumbs::for('tag-create', function ($trail) {
        $trail->parent('tag');
        $trail->push('Create', url('/tag/create'));
    });

//Library
    Breadcrumbs::for('library', function ($trail) {
        $trail->push('Library', url('/library'));
    });
    Breadcrumbs::for('library-show', function ($trail, $library) {
        $trail->parent('library');
        $trail->push($library->title, url('/library/'.$library->id));
    });
    Breadcrumbs::for('library-create', function ($trail) {
        $trail->parent('library');
        $trail->push('Create', url('/library/create'));
    });

// User
    Breadcrumbs::for('user', function ($trail) {
        $trail->push('User', url('#'));
    });
    Breadcrumbs::for('user-profile', function ($trail) {
        $trail->parent('user');
        $trail->push('Profile', url('/user/profile'));
    });

// News
    Breadcrumbs::for('news', function ($trail) {
        $trail->push('News', url('/news'));
    });
    Breadcrumbs::for('news-create', function ($trail) {
        $trail->parent('news');
        $trail->push('Create', url('/news/create'));
    });

// Teacher
    Breadcrumbs::for('teacher', function ($trail) {
        $trail->push('Teachers', url('/teacher'));
    });
    Breadcrumbs::for('teacher-create', function ($trail) {
        $trail->parent('teacher');
        $trail->push('Create', url('/teacher/create'));
    });
    Breadcrumbs::for('teacher-show', function ($trail, $teacher) {
        $trail->parent('teacher');
        $trail->push($teacher->getShortName().' - Show', url('/teacher/'.$teacher->id.'/show'));
    });

// Student
    Breadcrumbs::for('student', function ($trail) {
        $trail->push('Students', url('/student'));
    });
    Breadcrumbs::for('student-create', function ($trail) {
        $trail->parent('student');
        $trail->push('Create', url('/student/create'));
    });
    Breadcrumbs::for('student-show', function ($trail, $student) {
        $trail->parent('student');
        $trail->push($student->getShortName().' - Show', url('/student/'.$student->id.'/show'));
    });

// Discipline
    Breadcrumbs::for('discipline', function ($trail) {
        $trail->push('Disciplines', url('/discipline'));
    });
    Breadcrumbs::for('discipline-create', function ($trail) {
        $trail->parent('discipline');
        $trail->push('Create', url('/discipline/create'));
    });
    Breadcrumbs::for('discipline-edit', function ($trail, $discipline) {
        $trail->parent('discipline');
        $trail->push($discipline->display_name.' - Edit', url('/discipline/'.$discipline->id.'/edit'));
    });
    Breadcrumbs::for('discipline-show', function ($trail, $discipline) {
        $trail->parent('discipline');
        $trail->push($discipline->display_name.' - Show', url('/discipline/'.$discipline->id.'/show'));
    });

// Team
    Breadcrumbs::for('team', function ($trail) {
        $trail->push('Groups', url('/team'));
    });
    Breadcrumbs::for('team-create', function ($trail) {
        $trail->parent('team');
        $trail->push('Create', url('/team/create'));
    });
    Breadcrumbs::for('team-show', function ($trail, $team) {
        $trail->parent('team');
        $trail->push($team->display_name, url('/team/'.$team->name));
    });
    Breadcrumbs::for('team-show-setting', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Setting', url('/team/'.$team->name));
    });
    Breadcrumbs::for('team-teachers', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Teachers', url('/team/'.$team->name.'/teachers'));
    });
    Breadcrumbs::for('team-students', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Students', url('/team/'.$team->name.'/students'));
    });

    //Group Work
    Breadcrumbs::for('team-group-work', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Group Work', url('/team/'.$team->name.'/group-work'));
    });
    Breadcrumbs::for('team-group-work-show', function ($trail, $team, $discipline) {
        $trail->parent('team-group-work', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/group-work/'.$discipline->name));
    });
    Breadcrumbs::for('team-group-work-show-sub-teams', function ($trail, $team, $discipline, $groupWork) {
        $trail->parent('team-group-work-show', $team, $discipline);
        $trail->push('Teams', url('/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id));
    });
    Breadcrumbs::for('team-group-work-show-sub-teams-sub-team', function ($trail, $team, $discipline, $groupWork, $subTeam) {
        $trail->parent('team-group-work-show-sub-teams', $team, $discipline, $groupWork);
        $trail->push('Team', url('/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id.'/'.$subTeam->id));
    });
    //Activity
    Breadcrumbs::for('team-activity', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Activity', url('/team/'.$team->name.'/activity'));
    });
    Breadcrumbs::for('team-activity-show', function ($trail, $team, $discipline) {
        $trail->parent('team-activity', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/activity/'.$discipline->name));
    });
    Breadcrumbs::for('team-activity-create', function ($trail, $team) {
        $trail->parent('team-activity', $team);
        $trail->push('Create', url('/team/'.$team->name.'/activity/create'));
    });
    Breadcrumbs::for('team-activity-pass', function ($trail, $team, $discipline, $activity) {
        $trail->parent('team-activity-show', $team, $discipline);
        $trail->push($activity->getType(), url('/team/'.$team->name.'/activity/'.$discipline->name.'/pass/',$activity->id));
    });
    //Pretest
    Breadcrumbs::for('team-pretest', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Pretest', url('/team/'.$team->name.'/pretest'));
    });
    Breadcrumbs::for('team-material', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Materials', url('/team/'.$team->name.'/material'));
    });
    Breadcrumbs::for('team-pretest-discipline', function ($trail, $team, $discipline) {
        $trail->parent('team-pretest', $team);
        $trail->push($discipline->display_name, url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name));
    });
    Breadcrumbs::for('team-pretest-create', function ($trail, $team) {
        $trail->parent('team-pretest', $team);
        $trail->push('Create', url('/team/'.$team->name.'/pretest/create'));
    });
    Breadcrumbs::for('team-material-create', function ($trail, $team) {
        $trail->parent('team-material', $team);
        $trail->push('Create', url('/team/'.$team->name.'/material/create'));
    });
    Breadcrumbs::for('team-material-show', function ($trail, $team) {
        $trail->parent('team-material', $team);
        $trail->push('Show', url('/team/'.$team->name.'/material/show'));
    });
    Breadcrumbs::for('team-pretest-discipline-show', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline', $team, $discipline);
        $trail->push($pretest->name, url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id));
    });
    Breadcrumbs::for('team-pretest-discipline-show-statistic', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline-show', $team, $discipline, $pretest);
        $trail->push('Statistics', url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id));
    });
    Breadcrumbs::for('team-pretest-discipline-show-access', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline-show', $team, $discipline, $pretest);
        $trail->push('Access', url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id));
    });
    Breadcrumbs::for('team-pretest-discipline-show-pass', function ($trail, $team, $discipline, $pretest) {
        $trail->parent('team-pretest-discipline-show', $team, $discipline, $pretest);
        $trail->push('Passing test', url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/'));
    });

    //Mark
    Breadcrumbs::for('team-mark', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Marks', url('/team/'.$team->name.'/mark'));
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
        $trail->push('Create Task', url('/team/'.$team->name.'/mark/'.$discipline->name.'/task/create'));
    });

    //Template
        Breadcrumbs::for('team-template', function ($trail) {
            $trail->push('Group Templates', url('/team/template'));
        });
        Breadcrumbs::for('team-template-create', function ($trail) {
            $trail->parent('team-template');
            $trail->push('Create', url('/team/template/create'));
        });
        Breadcrumbs::for('team-template-edit', function ($trail, $template) {
            $trail->parent('team-template');
            $trail->push('Edit - '.$template->display_name, url('/team/template/'.$template->name.'/edit'));
        });
    //Homework
        Breadcrumbs::for('team-show-homework', function ($trail, $team) {
            $trail->parent('team-show', $team);
            $trail->push('Home Work', url('/team/'.$team->name.'/homework'));
        });
        Breadcrumbs::for('team-show-homework-discipline', function ($trail, $team, $discipline) {
            $trail->parent('team-show-homework', $team);
            $trail->push($discipline->display_name, url('/team/'.$team->name.'/homework/'.$discipline->name));
        });
        Breadcrumbs::for('team-show-homework-discipline-create', function ($trail, $team, $discipline) {
            $trail->parent('team-show-homework-discipline', $team, $discipline);
            $trail->push('Create', url('/team/'.$team->name.'/homework/'.$discipline->name.'/create'));
        });
        Breadcrumbs::for('team-show-homework-discipline-homework', function ($trail, $team, $discipline, $homeWork) {
            $trail->parent('team-show-homework-discipline', $team, $discipline);
            $trail->push($homeWork->display_name, url('/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name));
        });
        Breadcrumbs::for('team-show-homework-discipline-homework-edit', function ($trail, $team, $discipline, $homeWork) {
            $trail->parent('team-show-homework-discipline-homework', $team, $discipline, $homeWork);
            $trail->push('Edit', url('/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name.'/edit'));
        });
    //Schedule
    Breadcrumbs::for('team-show-schedule', function ($trail, $team) {
        $trail->parent('team-show', $team);
        $trail->push('Schedule', url('/team/'.$team->name.'/schedule'));
    });
    Breadcrumbs::for('team-show-schedule-create', function ($trail, $team) {
        $trail->parent('team-show-schedule', $team);
        $trail->push('Create', url('/team/'.$team->name.'/schedule/create'));
    });



/*
|--------------------------------------------------------------------------
| Top Manager Breadcrumbs
|--------------------------------------------------------------------------
*/
Breadcrumbs::for('top-manager', function ($trail) {
    $trail->push('Top Managers', url('/top-manager'));
});

Breadcrumbs::for('top-manager-create', function ($trail) {
    $trail->parent('top-manager');
    $trail->push('Create', url('/top-manager/create'));
});

/*
|--------------------------------------------------------------------------
| Manager Breadcrumbs
|--------------------------------------------------------------------------
*/
Breadcrumbs::for('manager', function ($trail) {
    $trail->push('Managers', url('/manager'));
});

Breadcrumbs::for('manager-create', function ($trail) {
    $trail->parent('manager');
    $trail->push('Create', url('/manager/create'));
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
        $trail->push('Schedule', url('/manage/student/team/'.$team->name));
    });
    Breadcrumbs::for('student-team-teachers', function ($trail, $team) {
        $trail->parent('student-team-dashboard', $team);
        $trail->push('Teachers', url('/manage/student/team/'.$team->name.'/teachers'));
    });
    Breadcrumbs::for('student-team-homework', function ($trail, $team) {
        $trail->parent('student-team-dashboard', $team);
        $trail->push('Home Work', url('/manage/student/team/'.$team->name.'/homework'));
    });
    Breadcrumbs::for('student-team-homework-discipline', function ($trail, $team, $discipline) {
        $trail->parent('student-team-homework', $team);
        $trail->push($discipline->display_name, url('/manage/student/team/'.$team->name.'/homework/'.$discipline->name));
    });
    Breadcrumbs::for('student-team-homework-discipline-homework', function ($trail, $team, $discipline, $homeWork) {
        $trail->parent('student-team-homework-discipline', $team, $discipline);
        $trail->push($homeWork->name, url('/manage/student/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name));
    });