<?php

/**
 * @apiGroup           Settings
 * @apiName            FindSetting
 *
 * @api                {GET} /v1/find_wechat_settings 公众号设置
 * @apiDescription     更新公众号设置
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "object":"User",
 * "id":eqwja3vw94kzmxr0,
 * "value":"设置内容",
 * }
 * }
 */

$router->get('find_wechat_settings', [
    'as'         => 'api_settings_find_wechat_setting',
    'uses'       => 'Controller@findWechatSetting',
    'middleware' => [
        'auth:api',
    ],
]);
