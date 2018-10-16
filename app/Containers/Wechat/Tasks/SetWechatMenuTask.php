<?php

namespace App\Containers\Wechat\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class SetWechatMenuTask extends Action
{

    /**
     * @return  array
     */
    public function run($buttons, $matchRule = null)
    {


        $officialAccount = \EasyWeChat::officialAccount();

//    Log::info('标签列表',$officialAccount->user_tag->list());

        if ($matchRule) {
            return $officialAccount->menu->create($buttons, $matchRule);
        } else {
            return $officialAccount->menu->create($buttons);
        }

    }
}
