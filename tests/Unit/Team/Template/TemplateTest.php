<?php

namespace Tests\Unit\Team\Template;

use App\Http\Controllers\Team\Template\TemplateController;
use App\Http\Requests\StoreTeamTemplate;
use App\TeamTemplate;
use App\User;
use Tests\TestCase;

class TemplateTest extends TestCase
{
    /**
     * Test Get Create Template Group Page
     *
     * @return void
     */
    public function testCreatePage()
    {
        $user = User::whereRoleIs('top-manager')->first();
        $this->be($user);

        $this->get('/team/template/create')
            ->assertStatus(200);
    }

    /**
     * Test Get Edit Default MBA Template Group Page
     *
     * @return void
     */
    public function testEditPage(){
        $user = User::whereRoleIs('top-manager')->first();
        $this->be($user);
        $template = TeamTemplate::first();

        $this->get('/team/template/'.$template->name.'/edit')
            ->assertStatus(200);
    }

    public function testCreateRequest(){
        $user = User::whereRoleIs('top-manager')->first();
        $this->be($user);

        $request = StoreTeamTemplate::create('/team/template/store', 'POST',[
            'name' => 'test',
            'display_name'  => 'Test',
        ]);

        $controller = new TemplateController();
        $response = $controller->store($request);
        $this->assertEquals(302, $response->getStatusCode());

        $this->get('/team/template/test/edit')
            ->assertStatus(200);

        TeamTemplate::where('name', 'test')->first()->delete();
    }
}
