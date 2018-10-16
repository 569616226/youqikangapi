<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class SyncPermissionsOnRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class SyncPermissionsOnRoleTest extends TestCase
{

    protected $endpoint = 'post@v1/permissions/sync';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    public function testSyncDuplicatedPermissionsToRole_()
    {

        $permissionA = factory(Permission::class)->create(['display_name' => 'AAA']);
        $permissionB = factory(Permission::class)->create(['display_name' => 'BBB']);

        $roleA = factory(Role::class)->create();
        $roleA->givePermissionTo($permissionA);

        $data = [
            'role_id'         => $roleA->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
            'name'            => 'update#name',
            'display_name'    => 'update#display_name',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '操作成功',
        ]);

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permissionA->id,
            'permission_id' => $permissionB->id,
            'role_id'       => $roleA->id,
        ]);

        $this->assertDatabaseHas('roles', [
            'id'           => $roleA->id,
            'name'         => $data['name'],
            'display_name' => $data['display_name'],
        ]);

        $this->assertCount(3, $roleA->revisionHistory);

    }

}
