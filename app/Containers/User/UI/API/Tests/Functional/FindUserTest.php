<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Tests\TestCase;

/**
 * Class FindUsersTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindClientTest extends TestCase
{

    protected $endpoint = 'get@v1/users/{id}?include=roles';

    protected $access = [
        'roles'       => '',
        'permissions' => 'search-users',
    ];

    public function testFindUser_()
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($admin->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($admin->name, $responseContent->data->name);
        $this->assertEquals($admin->username, $responseContent->data->username);
        $this->assertEquals($admin->phone, $responseContent->data->phone);
        $this->assertEquals($admin->is_frozen, $responseContent->data->is_frozen);
        $this->assertEquals($admin->wechat_name, $responseContent->data->wechat_name);
        $this->assertEquals($admin->wechat_avatar, $responseContent->data->wechat_avatar);
        $this->assertEquals($admin->open_id, $responseContent->data->open_id);
        $this->assertEquals($admin->is_wechat_verfiy ? '已绑定' : '未绑定', $responseContent->data->is_wechat_verfiy);
        $this->assertEquals($admin->created_at, $responseContent->data->created_at);
        $this->assertEquals($admin->updated_at, $responseContent->data->updated_at);
        $this->assertEquals($admin->deleted_at, $responseContent->data->deleted_at);

        $this->assertNotNull($responseContent->data->roles);
    }

}
