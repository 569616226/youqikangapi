<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class DeletePermissionTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeletePermissionTest extends TestCase
{

    protected $endpoint = 'delete@v1/permissions/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    public function testDeleteExistingPermission_()
    {

        $this->getTestingUser();

        $permission = factory(Permission::class)->create();

        $revisionHistory = $permission->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($permission->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $permission->display_name . ' 权限删除成功',
        ]);

        $deleted_permission = Permission::withTrashed()->find($permission->id);

        $this->assertCount($revisionHistory + 1, $deleted_permission->revisionHistory);
    }

}
