<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\{User, Role, RoleUser};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Role::truncate();
        RoleUser::truncate();


        #Create User Role
        Sentinel::getRoleRepository()
            ->createModel()
            ->create( [
                'name'       => 'User',
                'slug'       => 'user',
                'is_deletable' => false,
                'permissions'=> ['dashboard' => true]
            ]);

        #Create Super User
        $superUser = [
            'email'      => 'super@admin.com',
            'password'   => 'Sup@r!123',
            'first_name' => 'Super',
            'last_name'  => 'Admin',
            'user_type' => 9
        ];
        $superuserDb = Sentinel::registerAndActivate( $superUser );

        #Create Super Admin Role
        Sentinel::getRoleRepository()
            ->createModel()
            ->create( [
                'name'       => 'Master',
                'is_deletable' => false,
                'slug'       => 'master',
            ])
            ->users()
            ->attach( $superuserDb );

        #Create Admin User Role
        Sentinel::getRoleRepository()
            ->createModel()
            ->create( [
                'name'       => 'Admin',
                'slug'       => 'admin',
                'is_deletable' => false,
                'permissions'=> ['dashboard' => true]
            ]);
    }
}
