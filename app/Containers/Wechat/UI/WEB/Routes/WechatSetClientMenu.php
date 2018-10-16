<?php

/**
 * @var Route $router
 *
 * 设置客户联系人个性菜单
 */
$router->get('/wechat/set_client_menu', [
    'as'   => 'web_wechat_set_client_menu',
    'uses' => 'Controller@setWechatClientMenu',
]);
