<?php

$router->get('refresh_caches', [
    'as'   => 'refresh_system_caches',
    'uses' => 'Controller@refreshCaches',
]);
