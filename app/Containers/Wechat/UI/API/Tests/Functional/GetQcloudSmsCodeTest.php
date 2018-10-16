<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28
 * Time: 13:53
 * 需要测试手机绑定的时候才开启，以免每次测试都会有验证码
 */

namespace App\Containers\Wechat\UI\API\Tests\Functional\Mobile;


use App\Containers\User\Models\User;
use App\Containers\Wechat\Tests\TestCase;

class GetQcloudSmsCodeTest extends TestCase
{
    protected $endpoint = 'post@v1/get_sms_code';

    public function testGetQcloudSmsCodeSuccess_()
    {

        if ( config('comm.skip_test') ) {
            $this->markTestSkipped(
                '需要测试手机绑定的时候才开启，以免每次测试都会有验证码'
            );
        }

        $get_sms_data = [
            'phone' => 13412081338
        ];

        // send the HTTP request
        $response = $this->makeCall($get_sms_data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => "操作成功",
        ]);

    }


    public function testGetClientUserQcloudSmsCodeSuccess_()
    {
        if ( config('comm.skip_test') ) {
            $this->markTestSkipped(
                '需要测试手机绑定的时候才开启，以免每次测试都会有验证码'
            );
        }


        $get_sms_data = [
            'phone'     => 16620670512,
            'is_client' => true,
        ];

        factory(User::class)->create($get_sms_data);

        // send the HTTP request
        $response = $this->makeCall($get_sms_data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => "操作成功",
        ]);

    }

    public function testGetQcloudSmsCodeWithoutData_()
    {

        if ( config('comm.skip_test') ) {
            $this->markTestSkipped(
                '需要测试手机绑定的时候才开启，以免每次测试都会有验证码'
            );
        }

        $this->getTestingUser();
        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(422);


    }


    public function testGetQcloudSmsCodeError_()
    {

        $get_sms_data = [
            'phone' => 134120813281
        ];

        // send the HTTP request
        $response = $this->makeCall($get_sms_data);


        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => $get_sms_data['phone'] . '用户不存在',
        ]);

    }


}
