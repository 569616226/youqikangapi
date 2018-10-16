<?php

$router->get('logs', [
    'as'   => 'get_logs_page',
    'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index',
]);
