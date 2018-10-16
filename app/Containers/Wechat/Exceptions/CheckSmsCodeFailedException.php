<?php

namespace App\Containers\Wechat\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginFailedException
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class CheckSmsCodeFailedException extends Exception
{
    public $httpStatusCode = Response::HTTP_BAD_REQUEST;

    public $message = '手机绑定出错';
}
