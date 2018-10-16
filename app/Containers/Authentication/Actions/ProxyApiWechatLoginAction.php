<?php

namespace App\Containers\Authentication\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authentication\Events\LoginEvent;
use App\Containers\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Jenssegers\Agent\Agent;

/**
 * Class ProxyApiLoginAction.
 */
class ProxyApiWechatLoginAction extends Action
{

    /**
     * @param                                    $clientId
     * @param                                    $clientPassword
     *
     * @return  array
     */
    public function run($request,$open_id = null)
    {
        if (!$open_id) {
            $open_id = $request->open_id;
        }

        $user = User::where('open_id', $open_id)->first();

        if ($user) {//已经认证

            \Auth::login($user, true);

            if ($user->is_frozen) {

                return error_simple_respone('账号已被冻结');

            } else {

                $token = $user->createToken('My Token')->accessToken;

                if (env('GET_LOGIN_INFO', false)) {
                    \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                        ->dispatch(new LoginEvent(\Auth::user(), new Agent(), \Request::getClientIp()));
                }

                $responseContent = [
                    'is_client'    => $user->is_client,
                    'access_token' => $token,
                    'token_type'   => 'Bearer',
                ];


                return response()->json($responseContent);
            }

        } else {

            return error_simple_respone('账号没有认证');

        }

    }
}
