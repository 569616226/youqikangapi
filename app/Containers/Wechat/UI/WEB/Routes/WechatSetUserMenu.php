<?php

/**
 * @var Route $router
 *
 * 设置顾问个性菜单
 */
$router->get('/wechat/set_user_menu', [
    'as'   => 'web_wechat_set_user_menu',
    'uses' => 'Controller@setWechatUserMenu',
]);
