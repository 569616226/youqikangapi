<?php

/**
 * @var Route $router
 *
 * 菜单列表
 */
$router->get('/wechat/menus', [
    'as'   => 'web_wechat_get_menus',
    'uses' => 'Controller@getWechatMenus',
]);
