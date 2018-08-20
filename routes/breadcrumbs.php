<?php

// Manage
    Breadcrumbs::for('manage', function ($trail) {
        $trail->push('Manage', url('/manage'));
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
    Breadcrumbs::for('teacher-edit', function ($trail, $teacher) {
        $trail->parent('teacher');
        $trail->push($teacher->getShortName().' - Edit', url('/teacher/'.$teacher->id.'/edit'));
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
    Breadcrumbs::for('student-edit', function ($trail, $student) {
        $trail->parent('student');
        $trail->push($student->getShortName().' - Edit', url('/student/'.$student->id.'/edit'));
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

// Discipline
    Breadcrumbs::for('team', function ($trail) {
        $trail->push('Groups', url('/team'));
    });
    Breadcrumbs::for('team-create', function ($trail) {
        $trail->parent('team');
        $trail->push('Create', url('/team/create'));
    });
    Breadcrumbs::for('team-edit', function ($trail, $team) {
        $trail->parent('team');
        $trail->push('Edit - '.$team->display_name, url('/team/'.$team->name.'/edit'));
    });
    Breadcrumbs::for('team-show', function ($trail, $team) {
        $trail->parent('team');
        $trail->push($team->display_name.' - Show', url('/team/'.$team->name.'/show'));
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
        Breadcrumbs::for('team-edit-homework', function ($trail, $team) {
            $trail->parent('team-edit', $team);
            $trail->push('Home Work', url('/team/'.$team->name.'/homework'));
        });
        Breadcrumbs::for('team-edit-homework-discipline', function ($trail, $team, $discipline) {
            $trail->parent('team-edit-homework', $team);
            $trail->push($discipline->display_name, url('/team/'.$team->name.'/homework/'.$discipline->name));
        });
        Breadcrumbs::for('team-edit-homework-discipline-create', function ($trail, $team, $discipline) {
            $trail->parent('team-edit-homework-discipline', $team, $discipline);
            $trail->push('Create', url('/team/'.$team->name.'/homework/'.$discipline->name.'/create'));
        });
        Breadcrumbs::for('team-edit-homework-discipline-homework', function ($trail, $team, $discipline, $homeWork) {
            $trail->parent('team-edit-homework-discipline', $team, $discipline);
            $trail->push($homeWork->display_name, url('/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name));
        });
        Breadcrumbs::for('team-edit-homework-discipline-homework-edit', function ($trail, $team, $discipline, $homeWork) {
            $trail->parent('team-edit-homework-discipline-homework', $team, $discipline, $homeWork);
            $trail->push('Edit', url('/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name.'/edit'));
        });
    //Schedule
    Breadcrumbs::for('team-edit-schedule', function ($trail, $team) {
        $trail->parent('team-edit', $team);
        $trail->push('Schedule', url('/team/'.$team->name.'/schedule'));
    });
    Breadcrumbs::for('team-edit-schedule-create', function ($trail, $team) {
        $trail->parent('team-edit-schedule', $team);
        $trail->push('Create', url('/team/'.$team->name.'/schedule/create'));
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