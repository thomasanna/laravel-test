<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //create roles
        $superadminrole = Role::create(['name' => 'superadmin']); 
        $customerrole   = Role::create(['name' => 'customer']); 
        

        // create permissions

        $permissions[] = Permission::create(['name' => 'manage webiste info']);
        $permissions[] = Permission::create(['name' => 'manage users']);
        
        $superadminrole->syncPermissions($permissions);

        $password = 'admin123';

        User::create([ 'first_name' => 'Super', 'last_name' => 'Admin', 'email' => 'teenuthomas12@gmail.com', 'password' => Hash::make($password)]);

        $user = User::where('email','teenuthomas12@gmail.com')->first();
        $user->assignRole('superadmin');
    }
}
