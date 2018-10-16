<?php

namespace App\Containers\Wechat\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class SetWechatUserMenuAction extends Action
{

    /**
     * @return  array
     */
    public function run()
    {

        $mobile_url = env('APP_MOBILE_URL', 'https://wx.check.elinkport.com');
        $buttons = [
            [
                "type" => "view",
                "name" => "提交数据",
                "url"  => $mobile_url . "/#/Consultant/SelectionEnterprises"
            ],
        ];

        $matchRule = [
            "tag_id" => 101, //顾问
        ];

        return Apiato::call('Wechat@SetWechatMenuTask', [$buttons, $matchRule]);
    }
}
