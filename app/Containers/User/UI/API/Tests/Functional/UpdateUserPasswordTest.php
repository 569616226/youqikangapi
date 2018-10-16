<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class UpdateUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateUserPasswordTest extends TestCase
{

    protected $endpoint = 'put@v1/users/{id}/password';

    protected $access = [
        'roles'       => '',
        'permissions' => 'update-users',
    ];

    public function testUpdateExistingUserPassword_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create();

        $revisionHistory = $user->revisionHistory->count();

        $data = [
            'password' => 'updated#Password',
        ];

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $user->username . ' 用户密码更新成功',
        ]);

        $update_user = User::find($user->id);

        $this->assertCount($revisionHistory + 1, $update_user->revisionHistory);
    }

}


