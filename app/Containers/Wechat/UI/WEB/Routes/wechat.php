<?php

$router->any('/wechat', [
    'as'   => 'get_wechat_serve',
    'uses' => 'Controller@wechatServe',
]);
