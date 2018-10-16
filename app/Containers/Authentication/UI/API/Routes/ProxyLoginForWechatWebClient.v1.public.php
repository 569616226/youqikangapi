<?php

/**
 * @apiGroup           OAuth2
 * @apiName            ClientWechatWebAppLoginProxy
 * @api                {post} /v1/clients/web/wechat/login 微信登陆
 * @apiDescription     用户使用账号密码登陆
 *
 * @apiVersion         1.0.0
 *
 * @apiParam           {String}  open_id  微信id
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "token_type": "Bearer",
 * "expires_in": 315360000,
 * "access_token": "eyJ0eXAiOiJKV1QiLCJhbG...",
 * "refresh_token": "ZFDPA1S7H8Wydjkjl+xt+hPGWTagX..."
 * }
 */
$router->post('clients/web/wechat/login', [
    'as'   => 'api_authentication_client_wechat_web_app_login_proxy',
    'uses' => 'Controller@proxyLoginForWechatWebClient',
]);
