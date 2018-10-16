<?php

/**
 * @apiGroup           Users
 * @apiName            getAllAdmins
 * @api                {get} /v1/admins 管理员列表
 * @apiDescription     获取所有管理员
 *
 *                     你可以通过邮箱，名字和id搜索管理员，
 *                     例如: `?search=Mahmoud` or `?search=whatever@mail.com`.
 *                     你可以这样指定内容 `?search=email:whatever@mail.com` or `?search=id:20`.
 *                     你也可以这样指定多个值: `?search=name:Mahmoud&email:whatever@mail.com`.
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆管理员
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

$router->get('admins', [
    'as'         => 'api_user_get_all_admins',
    'uses'       => 'Controller@getAllAdmins',
    'middleware' => [
        'auth:api',
    ],
]);
