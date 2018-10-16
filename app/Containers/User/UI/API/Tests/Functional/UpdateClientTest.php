<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Company\Models\Company;
use App\Containers\Plan\Models\Plan;
use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class UpdateUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateClientTest extends TestCase
{

    protected $endpoint = 'put@v1/clients/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'update-users',
    ];

    public function testUpdateExistingClient_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create([
            'username' => 'username'
        ]);

        $revisionHistory = $user->revisionHistory->count();

        $company = factory(Company::class)->create();

        $data = [
            'username'   => $this->faker->name,
            'phone'      => $this->faker->unique()->phoneNumber,
            'company_id' => [$company->getHashedKey()],
            'is_client_admin' => true,
        ];

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '用户更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'phone'    => $data['phone'],
        ]);

        $update_user = User::find($user->id);

        $this->assertEquals($update_user->username, $data['username']);
        $this->assertEquals($update_user->phone, $data['phone']);
        $this->assertTrue(in_array($company->id, $update_user->companies->pluck('id')->toArray()));

        $this->assertCount($revisionHistory + 3, $update_user->revisionHistory);
    }

    public function testUpdateExistingUserError_()
    {


        $company = factory(Company::class)->create();

        $data = [

            'username'   => $this->faker->name,
            'phone'      => '13411001231',
            'company_id' => [$company->getHashedKey()],
            'is_client_admin' => true,
        ];

        $user = factory(User::class)->create(['phone' => '13411001234']);
        factory(User::class)->create(['phone' => '13411001231']);

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '此手机号码已被使用',
        ]);
    }

    public function testUpdateNonExistingUser_()
    {
        $data = [
            'username' => 'Updated Name',
        ];

        $fakeUserId = 7777;

        // send the HTTP request
        $response = $this->injectId($fakeUserId)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'status' => 'error'
        ]);
    }

    public function testUpdateExistingUserWithoutData_()
    {
        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.'
        ]);
    }

}


