<?php

namespace App\Containers\Wechat\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Wechat\UI\API\Requests\CheckSmsCodeInvitationRequest;
use App\Containers\Wechat\UI\API\Requests\CheckSmsCodeRequest;
use App\Containers\Wechat\UI\API\Requests\GetSmsCodeRequest;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class Controller extends ApiController
{

    /**
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getSmsCode(GetSmsCodeRequest $request)
    {
        return Apiato::call('Wechat@GetSmsCodeAction', [$request]);

    }


    /**
     * @return  \Illuminate\Http\JsonResponse
     */
    public function checkSmsCodeInvitation(CheckSmsCodeInvitationRequest $request)
    {
        return Apiato::call('Wechat@CheckSmsCodeInvitationAction', [$request]);

    }

}
