<?php

namespace App\Containers\Wechat\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class SetWechatClientMenuAction extends Action
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
                "name" => "查看报告",
                "url"  => $mobile_url . "/#/Owner/SelectReport"
            ],
        ];


        $matchRule = [
            "tag_id" => 100, //客户联系人
        ];

        return Apiato::call('Wechat@SetWechatMenuTask', [$buttons, $matchRule]);
    }
}
