<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Hardik Savani', 
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('123456')
        ]);
  
        $role = Role::create(['name' => 'Berichtswesen 1']);
        $role = Role::create(['name' => 'Berichtswesen 2']);
        $role = Role::create(['name' => 'Vertragswesen 1']);
        $role = Role::create(['name' => 'Vertragswesen 2']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
    }
}
