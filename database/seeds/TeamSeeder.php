<?php

use App\Permission;
use App\Role;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            'display_name' => 'A Default Group',
            'name' => 'a-default-group',
            'description' => 'This group was created automatically, by system.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        // Get default manager
        $manager = User::whereRoleIs('manager')->first();
        // Get ACL permission for manager
        $ownerGroup = Role::where('name', 'owner')->first();
        $createAcl = Permission::where('name', 'create-acl')->first();
        $readAcl = Permission::where('name', 'read-acl')->first();
        $updateAcl = Permission::where('name', 'update-acl')->first();
        // Get team
        $team = Team::first();
        // Attach manager to new team
        $manager->attachRole($ownerGroup, $team);
        $manager->attachPermissions([$createAcl,$readAcl,$updateAcl], $team);
    }
}
