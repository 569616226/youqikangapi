<?php

namespace App\Containers\Setting\UI\API\Tests\Functional;

use App\Containers\Settings\Tests\TestCase;

/**
 * Class GetAllUsersTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindWechatSettingsTest extends TestCase
{

    protected $endpoint = 'get@v1/find_wechat_settings';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-wechat_setting',
    ];

    public function testFindWechatSettings_()
    {

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals('优企康，让我们的企业更健康！我们是一个覆盖过千家进出口企业的风险管理平台，专注于为企业提供从订单，生产管理，到物流，关务，财务等环节的风险管理一体化解决方案。', $responseContent->data->value);

    }

}
