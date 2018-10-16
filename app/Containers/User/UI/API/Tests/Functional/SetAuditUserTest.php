<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class UpdateUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class SetAuditUserTest extends TestCase
{

    protected $endpoint = 'put@v1/users/{id}/audit';

    protected $access = [
        'roles'       => '',
        'permissions' => 'update-users',
    ];

    public function testSetAuditExistingUser_()
    {
        $this->getTestingUser();

        $user = factory(User::class)->create([
            'is_audit' => false
        ]);

        $revisionHistory = $user->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '设置成功',
        ]);

        $update_user = User::find($user->id);

        $this->assertTrue($update_user->is_audit);
        $this->assertCount($revisionHistory + 1, $update_user->revisionHistory);
    }


}


