<?php

namespace App\Containers\Authorization\Data\Seeders;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authorization\Models\Permission;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class AuthorizationPermissionsSeeder_1
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class AuthorizationPermissionsSeeder_1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Permissions ----------------------------------------------------------
        Apiato::call('Authorization@CreatePermissionTask', ['manage-roles', '角色管理']);
        Apiato::call('Authorization@CreatePermissionTask', ['create-admins', '创建管理员账号']);
        Apiato::call('Authorization@CreatePermissionTask', ['manage-admins-access', '管理员权限管理']);
        Apiato::call('Authorization@CreatePermissionTask', ['access-dashboard', '面板权限管理']);

        factory(Permission::class, 20)->create();
        // ...

    }
}
