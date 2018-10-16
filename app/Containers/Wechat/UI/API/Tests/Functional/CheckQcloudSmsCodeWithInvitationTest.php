<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28
 * Time: 13:53
 * 需要测试手机绑定的时候才开启，以免每次测试都会有验证码
 */

namespace App\Containers\Wechat\UI\API\Tests\Functional\Mobile;

use App\Containers\Invitation\Models\Invitation;
use App\Containers\User\Models\User;
use App\Containers\Wechat\Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class CheckQcloudSmsCodeWithInvitationTest extends TestCase
{

    protected $endpoint = 'post@v1/check_sms_code_invitation';

    public function testCheckClientUserQcloudSmsCodeWithInvitationCodeSuccess_()
    {

        $get_sms_data = [
            'phone' => 16620670512,
        ];

        $invitation = Invitation::first();
        $invitation_code = $invitation->code;
        $invitation_user = $invitation->users()->first();

        /*设置邀请人openid*/
        $invitation_user->open_id = 'ogAws1LSQr__Je_4FRTCrlJgbv0I';
        $invitation_user->save();

        Cache::put($get_sms_data['phone'] . 'sms_code', 5656, 10);

        $data = [
            'phone'           => 16620670512,
            'sms_code'        => Cache::get($get_sms_data['phone'] . 'sms_code'),
            'invitation_code' => $invitation_code,
            'open_id'         => 'ogAws1FTFygg1D0IYS7HDnXocErc',
            'wechat_name'     => 'required|max:255',
            'wechat_avatar'   => 'required|max:255',
            'username'        => 'username',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => "操作成功",
        ]);

        $update_user = User::wherePhone($data['phone'])->first();

        $this->assertEquals($update_user->open_id, $data['open_id']);
        $this->assertEquals($update_user->wechat_name, $data['wechat_name']);
        $this->assertEquals($update_user->wechat_avatar, $data['wechat_avatar']);

        $officialAccount = \EasyWeChat::officialAccount();

        $userTags = $officialAccount->user_tag->userTags($update_user->open_id);//获取用户标签id s数组
        //    $users = $officialAccount->user_tag->usersOfTag(100, $nextOpenId = '');//获取标签下用户数组

        $this->assertTrue(in_array(100, $userTags['tagid_list']));
        $this->assertNotNull(in_array(101, $userTags['tagid_list']));
    }

    public function testCheckClientUserQcloudSmsCodeWithInvitationCodeHasUsed_()
    {

        $get_sms_data = [
            'phone' => 16620670512,
        ];

        $invitation = Invitation::first();
        $invitation_code = $invitation->code;
        $invitation_user = $invitation->users()->first();

        $user = factory(User::class)->create();

        //使用授权码
        $invitation->users()->attach($user->id, ['is_client' => true]);

        /*设置邀请人openid*/
        $invitation_user->open_id = 'ogAws1LSQr__Je_4FRTCrlJgbv0I';
        $invitation_user->save();

        Cache::put($get_sms_data['phone'] . 'sms_code', 5656, 10);

        $data = [
            'phone'           => 16620670512,
            'sms_code'        => Cache::get($get_sms_data['phone'] . 'sms_code'),
            'invitation_code' => $invitation_code,
            'open_id'         => 'ogAws1FTFygg1D0IYS7HDnXocErc',
            'wechat_name'     => 'required|max:255',
            'wechat_avatar'   => 'required|max:255',
            'username'        => 'username',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => "授权码已被使用",
        ]);

    }

    public function testCheckAdminUserQcloudSmsCodeSuccess_()
    {

        $get_sms_data = [
            'phone' => '13412081337',
        ];

        $user = factory(User::class)->create([
            'phone'     => '13412081337',
            'is_client' => false,
        ]);

        Cache::put($get_sms_data['phone'] . 'sms_code', 5656, 10);

        $data = [
            'phone'         => 13412081337,
            'sms_code'      => Cache::get($get_sms_data['phone'] . 'sms_code'),
            'open_id'       => 'ogAws1FTFygg1D0IYS7HDnXocErc',
            'wechat_name'   => 'required|max:255',
            'wechat_avatar' => 'required|max:255',

        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => "操作成功",
        ]);

        $update_user = User::find($user->id);

        $this->assertEquals($update_user->open_id, $data['open_id']);
        $this->assertEquals($update_user->wechat_name, $data['wechat_name']);
        $this->assertEquals($update_user->wechat_avatar, $data['wechat_avatar']);
        $this->assertEquals($update_user->password, $user->password);

        $officialAccount = \EasyWeChat::officialAccount();

        $userTags = $officialAccount->user_tag->userTags($update_user->open_id);//获取用户标签id s数组
        //    $users = $officialAccount->user_tag->usersOfTag(100, $nextOpenId = '');//获取标签下用户数组

        $this->assertTrue(in_array(101, $userTags['tagid_list']));
        $this->assertNotNull(in_array(100, $userTags['tagid_list']));
    }

    public function testCheckClientAdminUserQcloudSmsCodeSuccess_()
    {

        $get_sms_data = [
            'phone' => '13412081337',
        ];

        $user = factory(User::class)->create([
            'phone'           => '13412081337',
            'is_client'       => true,
            'is_client_admin' => true,
        ]);

        Cache::put($get_sms_data['phone'] . 'sms_code', 5656, 10);

        $data = [
            'phone'         => 13412081337,
            'sms_code'      => Cache::get($get_sms_data['phone'] . 'sms_code'),
            'open_id'       => 'ogAws1FTFygg1D0IYS7HDnXocErc',
            'wechat_name'   => 'required|max:255',
            'wechat_avatar' => 'required|max:255',

        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => "操作成功",
        ]);

        $update_user = User::find($user->id);

        $this->assertEquals($update_user->open_id, $data['open_id']);
        $this->assertEquals($update_user->wechat_name, $data['wechat_name']);
        $this->assertNotEquals($update_user->username, $data['wechat_name']);
        $this->assertEquals($update_user->wechat_avatar, $data['wechat_avatar']);
        $this->assertEquals($update_user->password, $user->password);

        $officialAccount = \EasyWeChat::officialAccount();

        $userTags = $officialAccount->user_tag->userTags($update_user->open_id);//获取用户标签id s数组
        //    $users = $officialAccount->user_tag->usersOfTag(100, $nextOpenId = '');//获取标签下用户数组

        $this->assertTrue(in_array(100, $userTags['tagid_list']));
        $this->assertNotNull(in_array(101, $userTags['tagid_list']));
    }


    public function testCheckClientQcloudSmsCodeError_()
    {

        $get_sms_data = [
            'phone' => '13412081337',
        ];

        $user = factory(User::class)->create([
            'phone'           => '13412081337',
            'is_client'       => true,
            'is_client_admin' => false,
        ]);

        Cache::put($get_sms_data['phone'] . 'sms_code', 5656, 10);

        $data = [
            'phone'         => 13412081337,
            'sms_code'      => Cache::get($get_sms_data['phone'] . 'sms_code'),
            'open_id'       => 'ogAws1FTFygg1D0IYS7HDnXocErc',
            'wechat_name'   => 'required|max:255',
            'wechat_avatar' => 'required|max:255',

        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => "您不是本企业的负责人，如有不便请联系客服",
        ]);

    }

    public function testCheckQcloudSmsCodeError_()
    {

        $get_sms_data = [
            'phone' => 16620670512,
        ];

        $invitation = Invitation::first();
        $invitation_code = $invitation->code;

        Cache::put($get_sms_data['phone'] . 'sms_code', 5656, 10);

        $data = [
            'phone'           => 16620670512,
            'sms_code'        => 123,
            'open_id'         => 'ogAws1FTFygg1D0IYS7HDnXocErc',
            'invitation_code' => $invitation_code,
            'wechat_name'     => 'required|max:255',
            'wechat_avatar'   => 'required|max:255',
            'username'        => 'username',
        ];


        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => "验证码错误",
        ]);

    }


    public function testCheckQcloudSmsCodeWithoutData_()
    {

        $this->getTestingUser();
        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(422);


    }


}
