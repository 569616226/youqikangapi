<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class DeleteRoleTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteRoleTest extends TestCase
{

    protected $endpoint = 'delete@v1/roles/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    public function testDeleteExistingRole_()
    {

        $this->getTestingUser();

        $role = factory(Role::class)->create();

        $revisionHistory = $role->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($role->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $role->display_name . ' 角色删除成功',
        ]);

        $deleted_role = Role::withTrashed()->find($role->id);

        $this->assertCount($revisionHistory + 1, $deleted_role->revisionHistory);
    }

}
