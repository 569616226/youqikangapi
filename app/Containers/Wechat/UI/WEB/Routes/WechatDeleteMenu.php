<?php

/**
 * @var Route $router
 *
 * 删除菜单
 */
$router->get('/wechat/delete_menu/{id?}', [
    'as'   => 'web_wechat_delete_menu',
    'uses' => 'Controller@deleteWechatMenu',
]);
