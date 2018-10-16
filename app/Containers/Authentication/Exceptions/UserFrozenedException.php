<?php

namespace App\Containers\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginFailedException
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class UserFrozenedException extends Exception
{
    public $httpStatusCode = Response::HTTP_OK;

    public $message = '账号已被冻结';
}
