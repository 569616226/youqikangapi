<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class UpdatePermissionTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdatePermissionTest extends TestCase
{

    protected $endpoint = 'put@v1/permissions/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    public function testUpdateExistingPermission_()
    {
        $this->getTestingUser();

        $permission = Apiato::call('Authorization@CreatePermissionTask',
            ['advisor', '顾问', '处理客户报告知道相关工作']
        );

        $revisionHistory = $permission->revisionHistory->count();

        $data = [
            'display_name' => $this->faker->name,
            'description'  => $this->faker->name,
        ];

        // send the HTTP request
        $response = $this->injectId($permission->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '权限更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('permissions', [
            'display_name' => $data['display_name'],
            'description'  => $data['description'],
        ]);

        $update_permission = Permission::find($permission->id);

        $this->assertCount($revisionHistory + 2, $update_permission->revisionHistory);
    }


}


