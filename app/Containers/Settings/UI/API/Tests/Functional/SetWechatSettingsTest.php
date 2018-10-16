<?php

namespace App\Containers\Setting\UI\API\Tests\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Settings\Tests\TestCase;

/**
 * Class GetAllUsersTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class SetWechatSettingsTest extends TestCase
{

    protected $endpoint = 'patch@v1/set_wechat_settings';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-wechat_setting',
    ];

    public function testSetWechatSettings_()
    {
        $data = [
            'wechat' => 'update#wehcat'
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '操作成功',
        ]);

        $wechat = Apiato::call('Settings@FindSettingByKeyTask', ['wechat']);

        $this->assertEquals($data['wechat'], $wechat->value);

    }

}
