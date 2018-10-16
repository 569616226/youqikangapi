<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class UpdateUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateUserTest extends TestCase
{

    protected $endpoint = 'put@v1/users/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'update-users',
    ];

    public function testUpdateExistingUser_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create();

        $revisionHistory = $user->revisionHistory->count();

        $role = Apiato::call('Authorization@CreateRoleTask',
            ['advisor', '顾问', '处理客户报告知道相关工作', 9999]
        );

        $data = [
            'password'        => 'updated#Password',
            'username'        => 'updated#username',
            'phone'           => 'updated#phone',
            'role_id'         => $role->getHashedKey(),
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

        $this->assertCount($revisionHistory + 3, $update_user->revisionHistory);
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

    public function testUpdateExistingUserError_()
    {
        $role = Apiato::call('Authorization@CreateRoleTask',
            ['advisor', '顾问', '处理客户报告知道相关工作', 9999]
        );

        $data = [
            'username' => '13411001231',
            'phone'    => '13411001231',
            'role_id'  => $role->getHashedKey(),
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

    public function testUpdateExistingUserWithEmptyValues()
    {
        $data = [
            'username' => '123',
            'password' => '123',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct


        $response->assertStatus(422);

        $this->assertValidationErrorContain([
            // messages should be updated after modifying the validation rules, to pass this test
            'password' => 'The password must be at least 6 characters.',
        ]);

    }
}


