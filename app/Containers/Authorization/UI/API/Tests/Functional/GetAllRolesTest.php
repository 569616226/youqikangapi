<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\TestCase;

/**
 * Class GetAllRolesTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllRolesTest extends TestCase
{

    protected $endpoint = 'get@v1/roles';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    public function testGetAllRoles_()
    {
        $this->getTestingUser();

        $role = factory(Role::class)->create([
            'created_at' => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $role_names = array_pluck($responseContent->data, 'name');

        $this->assertTrue(count($responseContent->data) > 0);
        $this->assertEquals($role->name, $responseContent->data[0]->name);
        $this->assertFalse(in_array('admin', $role_names));
        $this->assertFalse(in_array('guest', $role_names));
    }

}
