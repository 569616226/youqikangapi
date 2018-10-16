<?php

namespace App\Containers\Wechat\Tasks;

use App\Containers\User\Models\User;
use App\Containers\Wechat\Exceptions\GetSmsCodeFailedException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Support\Facades\Cache;
use Qcloud\Sms\SmsSingleSender;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetSmsCodeTask extends Action
{

    /**
     * @return  array
     */
    public function run($phone)
    {

        $appid = config('wechat-container.app_id');
        $appkey = config('wechat-container.app_key');
        $tempId = config('wechat-container.temp_id');
        $sms_code = $this->getSmsCode();

        try {

            $sender = new SmsSingleSender($appid, $appkey);
            $params = [$sms_code];// 假设模板内容为：测试短信，{1}，{2}，{3}，上学。
            $result = $sender->sendWithParam("86", $phone, $tempId, $params, "", "", "");
            $rsp = json_decode($result);

            if ($rsp->result == 0 && $rsp->errmsg == 'OK') {

                Cache::put($phone . 'sms_code', $sms_code, 10);

                return success_simple_respone();

            } else {

                return ['error_code' => $rsp->result, 'error_msg' => $rsp->errmsg];
            }

        } catch (Exception $exception) {

            report($exception);
            throw new GetSmsCodeFailedException();

        }
    }

    /**
     * @return int
     */
    private function getSmsCode()
    {
        return rand(1000, 9999);
    }
}
