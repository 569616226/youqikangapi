<?php


/**
 * @apiGroup           Wechat
 * @apiName            checkInvitationSmsCode
 *
 * @api                {POST} /v1/check_sms_code_invitation 认证用户
 * @apiDescription      认证用户
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆
 *
 * @apiParam          {Nmuber}  phone 手机号码
 * @apiParam          {Nmuber}  sms_code 验证码
 * @apiParam          {String}  open_id 微信id
 * @apiParam          {Nmuber}  [invitation_code] 邀请码
 * @apiParam          {String}  wechat_name 微信名
 * @apiParam          {String}  [username] 姓名
 * @apiParam          {String}  wechat_avatar 微信头像
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

// API Root route
$router->post('/check_sms_code_invitation', [
    'as'   => 'api_check_sms_code_invitation',
    'uses' => 'Controller@checkSmsCodeInvitation',
]);
