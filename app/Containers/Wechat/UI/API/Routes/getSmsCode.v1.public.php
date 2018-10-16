<?php


/**
 * @apiGroup           Wechat
 * @apiName            getSmsCode
 *
 * @api                {POST} /v1/get_sms_code 获取验证码
 * @apiDescription      获取验证码
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆
 *
 * @apiParam          {Nmuber}  phone 手机号码
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "status":"true"
 * "sms_code":"验证码",
 * }
 * }
 */

// API Root route
$router->post('/get_sms_code', [
    'as'   => 'api_get_sms_code',
    'uses' => 'Controller@getSmsCode',
]);
