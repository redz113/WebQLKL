<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Quản trị viên',
            'username' => 'admin',
            'role' => 1,
            'email' => 'lexuanhien@hnue.edu.vn',
            'password' => bcrypt('Admin123@')
        ]);

        $role = Role::create(['name' => 'Quản trị viên']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);


        //Chuyên viên
        $user = User::create([
            'name' => 'Chuyên viên Bộ',
            'username' => 'cv01',
            'role' => 2,
            'email' => '',
            'password' => bcrypt('Abc123@')
        ]);
        $role = Role::create(['name' => 'Chuyên viên Bộ']);
        $permissions = [1,2,3,13,14,15,17,18,19,20,21,22,23,25,26,27,28,29,33, 35, 37, 38, 39, 40, 41];
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}