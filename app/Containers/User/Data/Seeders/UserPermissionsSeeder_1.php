<?php

namespace App\Containers\User\Data\Seeders;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class UserPermissionsSeeder_1
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class UserPermissionsSeeder_1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Permissions ----------------------------------------------------------
        Apiato::call('Authorization@CreatePermissionTask', ['search-users', '搜索用户']);
        Apiato::call('Authorization@CreatePermissionTask', ['list-users', '用户列表']);
        Apiato::call('Authorization@CreatePermissionTask', ['create-users', '创建联系人']);
        Apiato::call('Authorization@CreatePermissionTask', ['update-users', '更新用户']);
        Apiato::call('Authorization@CreatePermissionTask', ['delete-users', '删除用户']);
        Apiato::call('Authorization@CreatePermissionTask', ['refresh-users', '重置用户']);

        factory(User::class, 20)->create([
            'is_client' => true
        ]);

        // ...

    }
}
