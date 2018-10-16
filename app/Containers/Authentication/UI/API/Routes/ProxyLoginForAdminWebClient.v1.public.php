<?php

/**
 * @apiGroup           OAuth2
 * @apiName            ClientAdminWebAppLoginProxy
 * @api                {post} /v1/clients/web/admin/login 账号密码登陆
 * @apiDescription     用户使用账号密码登陆
 *
 * @apiVersion         1.0.0
 *
 * @apiParam           {String}  name  账号名
 * @apiParam           {String}  password 密码
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
$router->post('clients/web/admin/login', [
    'as'   => 'api_authentication_client_admin_web_app_login_proxy',
    'uses' => 'Controller@proxyLoginForAdminWebClient',
]);
