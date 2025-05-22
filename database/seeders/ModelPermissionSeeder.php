<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\ModelForPermission;

class ModelPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();
        ModelForPermission::truncate();

        $modelArray = ['Role Management','System User Management','User Management','Payment Management','Chapter Management', 'Notification Management', 'General'];
        foreach($modelArray as $model){
            ModelForPermission::create([
                'model' => $model
            ]);
        }

        $permissionArry = [
            [
                'route' => 'admin/role',
                'display_name' => 'View Roles',
                'permissions_name' => 'role.view',
                'model_id' => 1
            ],
            [
                'route' => 'admin/role/add',
                'display_name' => 'Add Roles',
                'permissions_name' => 'role.add',
                'model_id' => 1
            ],
            [
                'route' => 'admin/role/edit/{role}',
                'display_name' => 'Edit Roles',
                'permissions_name' => 'role.edit',
                'model_id' => 1
            ],
            [
                'route' => 'admin/role/delete/{role}',
                'display_name' => 'Delete Roles',
                'permissions_name' => 'role.delete',
                'model_id' => 1
            ],
            [
                'route' => 'admin/users',
                'display_name' => 'View Users',
                'permissions_name' => 'user.view',
                'model_id' => 3
            ],
            [
                'route' => 'admin/user/edit/{userId}',
                'display_name' => 'Edit Users',
                'permissions_name' => 'user.edit',
                'model_id' => 3
            ],
            [
                'route' => 'admin/user/delete/{userId}',
                'display_name' => 'Delete Users',
                'permissions_name' => 'user.delete',
                'model_id' => 3
            ],
            [
                'route' => 'admin/user/edit/password',
                'display_name' => 'Users Password Change',
                'permissions_name' => 'user.password.change',
                'model_id' => 3
            ],
            [
                'route' => 'admin/user/{userId}/status',
                'display_name' => 'Active/Inactive Users',
                'permissions_name' => 'user.status.change',
                'model_id' => 3
            ],
            [
                'route' => 'admin/udpcardprinting/{userId}',
                'display_name' => 'Print User ID Card',
                'permissions_name' => 'user.print.card',
                'model_id' => 3
            ],
            [
                'route' => 'admin/system_user',
                'display_name' => 'View System User',
                'permissions_name' => 'systemUser.view',
                'model_id' => 2
            ],
            [
                'route' => 'admin/system_user/add',
                'display_name' => 'Add System User',
                'permissions_name' => 'systemUser.add',
                'model_id' => 2
            ],
            [
                'route' => 'admin/system_user/edit/{userId}',
                'display_name' => 'Edit System User',
                'permissions_name' => 'systemUser.edit',
                'model_id' => 2
            ],
            [
                'route' => 'admin/system_user/delete/{userId}',
                'display_name' => 'Delete System User',
                'permissions_name' => 'systemUser.delete',
                'model_id' => 2
            ],
            [
                'route' => 'admin/chapter',
                'display_name' => 'View Chapter',
                'permissions_name' => 'chapter.view',
                'model_id' => 5
            ],
            [
                'route' => 'admin/chapter/add',
                'display_name' => 'Add Chapter',
                'permissions_name' => 'chapter.add',
                'model_id' => 5
            ],
            [
                'route' => 'admin/chapter/edit/{chapterId}',
                'display_name' => 'Edit Chapter',
                'permissions_name' => 'chapter.edit',
                'model_id' => 5
            ],
            [
                'route' => 'admin/chapter/delete/{chapterId}',
                'display_name' => 'Delete Chapter',
                'permissions_name' => 'chapter.delete',
                'model_id' => 5
            ],
            [
                'route' => 'admin/notification',
                'display_name' => 'Send Mail Notification',
                'permissions_name' => 'notification.mail.send',
                'model_id' => 6
            ],
            [
                'route' => 'admin/dashboard',
                'display_name' => 'Dashboard',
                'permissions_name' => 'user.dashboard',
                'model_id' => 7
            ],
        ];
        foreach($permissionArry as $permission){
            Permission::create($permission);
        }
    }
}
