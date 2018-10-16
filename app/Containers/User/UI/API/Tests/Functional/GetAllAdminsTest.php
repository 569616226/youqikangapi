<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class GetAllUsersTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllAdminsTest extends TestCase
{

    protected $endpoint = 'get@v1/admins';

    protected $access = [
        'roles'       => '',
        'permissions' => 'list-users',
    ];

    public function testGetAllAdmins_()
    {
        // create some non-admin users
        factory(User::class, 2)->create([
            'is_client' => false
        ]);

        // should not be returned
        $client = factory(User::class)->create([
            'is_client'  => false,
            'created_at' => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        // assert the returned data size is correct
        // 2 (fake in this test) + 1 (that is logged in) + 1 (seeded super admin)
        $this->assertCount(4, $responseContent->data);
        $this->assertEquals($client->name, $responseContent->data[0]->name);

    }

    public function testGetAllAdminsByNonAdmin_()
    {
        $this->getTestingUserWithoutAccess();

        // create some fake users
        factory(User::class, 2)->create();

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(403);

        $this->assertResponseContainKeyValue([
            'errors'  => 'You have no access to this resource!',
            'message' => 'This action is unauthorized.',
        ]);
    }

}
