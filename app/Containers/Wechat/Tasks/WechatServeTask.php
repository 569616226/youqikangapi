<?php

namespace App\Containers\Wechat\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class WechatServeTask extends Task
{

    public function run()
    {
        try {

            //      \Log::info('request arrived.');
            # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

            $officialAccount = \EasyWeChat::officialAccount();
            $officialAccount->server->push(function ($message) use ($officialAccount) {

                $setting = Apiato::call('Settings@FindSettingByKeyTask', ['wechat']);

                switch ($message['MsgType']) {

                    case 'event':

                        if (array_key_exists('Event', $message) && $message['Event'] == 'subscribe') {

                            /*
                             * 如果用户关注过，并且认证过
                             *
                             * 为用户设置标签
                            */
                            $users = User::where('open_id', $message['FromUserName'])->get();
                            if (!$users->isEmpty()) {

                                $user = $users->first();

                                if ($user->is_wechat_verfiy && $user->wechat_verfiy_time) {

                                    /*为用户打标签*/
                                    $user_tagId = $user->is_client ? 100 : 101;

                                    $officialAccount->user_tag->tagUsers([$message['FromUserName']], $user_tagId);

                                }

                            }

                        }

                        break;
                    case 'text':

                        break;
                    case 'image':

                        break;
                    case 'voice':

                        break;
                    case 'video':

                        break;
                    case 'location':

                        break;
                    case 'link':

                        break;
                    case 'file':


                    default:

                        break;
                }

                return html_entity_decode(stripslashes($setting->value));

            });

            return $officialAccount->server->serve();

        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
