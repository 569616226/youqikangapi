<?php

/**
 * @apiGroup           Settings
 * @apiName            setSetting
 *
 * @api                {PATCH} /v1/set_wechat_settings更新公众号设置
 * @apiDescription     更新公众号设置
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  wechat 微信关注回复字段
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->patch('set_wechat_settings', [
    'as'         => 'api_settings_set_wechat_setting',
    'uses'       => 'Controller@setWechatSetting',
    'middleware' => [
        'auth:api',
    ],
]);
