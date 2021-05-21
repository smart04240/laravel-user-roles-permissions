<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        $permissions = [
            'article-view',
            'article-edit',
            'article-delete',
            'article-submit',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Berichtswesen 1']);
        $role1->givePermissionTo('article-view');

        $role2 = Role::create(['name' => 'Berichtswesen 2']);
        $role2->givePermissionTo('article-view');
        $role2->givePermissionTo('article-edit');

        $role3 = Role::create(['name' => 'Vertragswesen 1']);
        $role3->givePermissionTo('article-view');
        $role3->givePermissionTo('article-edit');
        $role3->givePermissionTo('article-delete');

        $role4 = Role::create(['name' => 'Vertragswesen 2']);
        $role4->givePermissionTo('article-view');
        $role4->givePermissionTo('article-edit');
        $role4->givePermissionTo('article-delete');
        $role4->givePermissionTo('article-submit');

        // Create demo users
        $user = User::create([
            'name' => 'Berichtswesen 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole($role1);

        $user = User::create([
            'name' => 'Berichtswesen 2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'name' => 'Vertragswesen 1',
            'email' => 'user3@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole($role3);

        $user = User::create([
            'name' => 'Vertragswesen 2',
            'email' => 'user4@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole($role4);
    }
}
