<?php

/**
 * @apiGroup           Image
 * @apiName            updateImage
 *
 * @api                {POST} /v1/upload_image 上传图片
 * @apiDescription     上传图片
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  image 图片文件
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "status":true | false,
 * "url":"图片路由",
 * }
 */

/** @var Route $router */
$router->post('upload_image', [
    'as'         => 'api_image_upload_image',
    'uses'       => 'Controller@uploadImage',
    'middleware' => [
        'auth:api',
    ],
]);
