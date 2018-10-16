<?php

namespace App\Containers\Wechat\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CheckSmsCodeInvitationAction extends Action
{

    /**
     * @return  array
     */
    public function run(Request $request)
    {
        $data = [
            'phone'              => $request->phone,
            'open_id'            => $request->open_id,
            'wechat_name'        => $request->wechat_name,
            'wechat_avatar'      => $request->wechat_avatar,
            'wechat_verfiy_time' => now(),
            'is_wechat_verfiy'   => true,
            'username'           => $request->username ?? $request->wechat_name,

        ];

        return Apiato::call('Wechat@CheckSmsCodeInvitationTask', [$data, $request->sms_code, $request->invitation_code]);
    }
}
