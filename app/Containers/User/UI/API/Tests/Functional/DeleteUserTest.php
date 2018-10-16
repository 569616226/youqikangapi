<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class DeleteUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteUserTest extends TestCase
{

    protected $endpoint = 'delete@v1/users/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'delete-users',
    ];

    public function testDeleteExistingUser_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create();

        $revisionHistory = $user->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $user->username . ' 用户删除成功',
        ]);

        $deleted_user = User::withTrashed()->find($user->id);

        $this->assertCount($revisionHistory + 1, $deleted_user->revisionHistory);
    }

    public function testDeleteExistingUserIsAudit_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create([
            'is_client' => false,
            'is_audit'  => true,
        ]);

        $revisionHistory = $user->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '不能删除项目审核人',
        ]);

    }

    public function testDeleteExistingUserIsClientAdmin_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create([
            'is_client'       => true,
            'is_client_admin' => true,
        ]);

        $revisionHistory = $user->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '不能删除企业主',
        ]);


    }

    public function testDeleteAnotherExistingUser_()
    {
        // make the call form the user token who has no access
        $this->getTestingUserWithoutAccess();

        $anotherUser = factory(User::class)->create();

        // send the HTTP request
        $response = $this->injectId($anotherUser->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(403);
    }
}
