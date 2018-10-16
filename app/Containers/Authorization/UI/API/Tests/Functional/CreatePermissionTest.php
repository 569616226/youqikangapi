<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreatePermissionTest extends TestCase
{

    protected $endpoint = 'post@v1/permissions';

    protected $auth = true;

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    public function testCreatePermission_()
    {
        $this->getTestingUser();

        $data = [
            'name'         => 'manager',
            'display_name' => 'manager',
            'description'  => 'he manages things',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $data['display_name'] . ' 权限新建成功',
        ]);

        $role = Permission::whereName($data['name'])->first();

        $this->assertCount(1, $role->revisionHistory);

    }

    public function testCreatePermissionWithWrongName_()
    {
        $this->getTestingUser();

        $data = [
            'name'         => 'include space',
            'display_name' => 'manager',
            'description'  => 'he manages things',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);
    }

}
