<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class UpdateUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class reFrozenUserTest extends TestCase
{

    protected $endpoint = 'put@v1/users/{id}/refrozen';

    protected $access = [
        'roles'       => '',
        'permissions' => 'update-users',
    ];

    public function testreFrozenExistingUser_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create(['is_frozen' => true]);

        $revisionHistory = $user->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $user->username . ' 用户解冻成功',
        ]);

        $update_user = User::find($user->id);

        $this->assertCount($revisionHistory + 1, $update_user->revisionHistory);
        $this->assertFalse($update_user->is_frozen);
    }

}


