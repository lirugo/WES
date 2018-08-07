<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerPageTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/')->assertRedirect('/login');;
    }

    public function testManagePage()
    {
        $user = User::whereRoleIs('manager')->first();
        $this->be($user);

        $this->get('/')
            ->assertStatus(200);

        $this->get('/manage')
            ->assertStatus(200);
    }

    public function testTeacherPage()
    {
        $user = User::whereRoleIs('manager')->first();
        $this->be($user);

        $this->get('/teacher/create')
            ->assertStatus(200);

        $this->get('/teacher')
            ->assertStatus(200);

        $this->get('/teacher/4')
            ->assertStatus(200);

        $this->get('/teacher/4/edit')
            ->assertStatus(200);
    }

    public function testStudentPage()
    {
        $user = User::whereRoleIs('manager')->first();
        $this->be($user);

        $this->get('/student/create')
            ->assertStatus(200);

        $this->get('/student')
            ->assertStatus(200);

        $this->get('/student/5')
            ->assertStatus(200);

//        $this->get('/student/5/edit')
//            ->assertStatus(200);
    }

    public function testTeamPage()
    {
        $user = User::whereRoleIs('manager')->first();
        $this->be($user);

        $this->get('/team/create')
            ->assertStatus(200);

        $this->get('/team')
            ->assertStatus(200);

        $this->get('/team/a-default-group')
            ->assertStatus(200);

        $this->get('/team/a-default-group/edit')
            ->assertStatus(200);
    }

    public function testDisciplinePage()
    {
        $user = User::whereRoleIs('manager')->first();
        $this->be($user);

        $this->get('/discipline/create')
            ->assertStatus(200);

        $this->get('/discipline')
            ->assertStatus(200);

        $this->get('/discipline/management/edit')
            ->assertStatus(200);
    }
}
