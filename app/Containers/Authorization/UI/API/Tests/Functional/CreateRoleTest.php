<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateRoleTest extends TestCase
{

    protected $endpoint = 'post@v1/roles';

    protected $auth = true;

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    public function testCreateRole_()
    {

        $permissionA = factory(Permission::class)->create(['display_name' => 'AAA']);
        $permissionB = factory(Permission::class)->create(['display_name' => 'BBB']);

        $data = [
            'name'            => 'manager',
            'display_name'    => 'manager',
            'description'     => 'he manages things',
            'permissions_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $data['display_name'] . ' 角色新建成功',
        ]);

        $role = Role::whereName($data['name'])->first();

        $this->assertCount(1, $role->revisionHistory);

    }

    public function testCreateRoleWithWrongName_()
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
