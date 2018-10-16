<?php

namespace App\Containers\Authentication\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authentication\Events\LoginEvent;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

/**
 * Class ProxyApiLoginAction.
 */
class ProxyApiLoginAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     * @param                                    $clientId
     * @param                                    $clientPassword
     *
     * @return  array
     */
    public function run(Request $request, $clientId, $clientPassword)
    {
        $requestData = [
            'grant_type'    => 'password',
            'client_id'     => $clientId,
            'client_secret' => $clientPassword,
            'username'      => $request->name,
            'password'      => $request->password,
            'scope'         => '',
        ];

        // check if user email is confirmed only if that feature is enabled.
        Apiato::call('Authentication@CheckIfUserIsConfirmedTask', [],
            [['loginWithCredentials' => [$requestData['username'], $requestData['password']]]]);

        if (optional(Auth::user())->name !== $requestData['username']) {

            return error_simple_respone('账号名或者密码错误');

        } elseif (optional(Auth::user())->is_frozen) {

            return error_simple_respone('账号已被冻结');

        } else {

            $responseContent = Apiato::call('Authentication@CallOAuthServerTask', [$requestData]);

            $refreshCookie = Apiato::call('Authentication@MakeRefreshCookieTask', [$responseContent['refresh_token']]);

            \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                ->dispatch(new LoginEvent(\Auth::user(), new Agent(), \Request::getClientIp()));

            return response()->json($responseContent)->withCookie($refreshCookie);
        }

    }
}
