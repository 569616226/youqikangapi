<?php

namespace App\Containers\Wechat\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Wechat\Events\BangdingEvent;
use App\Containers\User\Models\User;
use App\Containers\Wechat\Exceptions\CheckSmsCodeFailedException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CheckSmsCodeInvitationTask extends Action
{

    /**
     * @return  array
     */
    public function run(array $data, $sms_code, $invitation_code)
    {

        try {

            $officialAccount = \EasyWeChat::officialAccount();
            $client = null;
            $cace_sms_code = $data['phone'] . 'sms_code';//验证码

            if (!$data['open_id']) {

                \DB::rollback();
                return error_simple_respone('请先关注优企康平台公众号');

            } else {

                //      如果验证码正确，或者是测试环境
                if (Cache::get($cace_sms_code) && $sms_code == Cache::get($cace_sms_code) || $sms_code == config('wechat-container.test_sms_code')) {

                    \DB::beginTransaction();

                    /*如果是客户联系人认证*/
                    if ($invitation_code) {

                        $data['name'] = $data['phone'];
                        $data['is_client'] = true;
                        $data['is_client_admin'] = false;
                        $data['password'] = Hash::make($data['open_id']);

                        $invitation = Apiato::call('Invitation@FindInvitationByCodeTask', [$invitation_code]);//授权码

                        if ($invitation->clients->first()) {

                            \DB::rollback();
                            return error_simple_respone('授权码已被使用');

                        }

                        $client = $invitation->users->first();//授权人
                        $company_ids = $client->companies()->pluck('id')->toArray();//授权人的公司
                        $roleids = $client->roles()->pluck('id')->toArray();//授权人的角色

                        $user = \App::make(User::class)->create($data);
                        $user->syncRoles($roleids);
                        $user->companies()->attach($company_ids);

                        /*使用授权码*/
                        $invitation->users()->attach($user->id, ['is_client' => true]);

                        //  如果是顾问认证和企业主
                    } else {

                        $users = User::where('phone', $data['phone'])->get();

                        if ($users->isEmpty()) {

                            \DB::rollback();
                            return error_simple_respone($data['phone'] . '用户不存在');

                        } else {

                            $user = $users->first();
                            //企业主的名字不替换为微信名
                            $data['username'] = $user->username;


                            if ($user->is_client && !$user->is_client_admin) {

                                \DB::rollback();
                                return error_simple_respone('您不是本企业的负责人，如有不便请联系客服');

                            } else {

                                $user = Apiato::call('User@UpdateUserTask', [
                                    $data,
                                    $user->id,
                                    $user->roles->pluck('id')->toArray()
                                ]);

                                /*如果返回的不是用户对象*/
                                if (!$user instanceof User) {

                                    \DB::rollback();
                                    return $user;
                                }

                            }
                        }

                    }

                    /*
                     * 因为要请求微信公众号的接口，这里要设置访问ip。
                     * 虚拟机的ip时常会变化，如果ip不对会报 errcode":40164 错误。
                     * 这时候要到公众号平台设置ip白名单
                     *
                     * */
                    $open_id = $user->open_id ?? $data['open_id'];
                    $userTags = $officialAccount->user_tag->userTags($open_id);

                    /*为用户打标签*/
                    $user_tagId = $user->is_client ? 100 : 101;
                    /*如果有标签，移除标签*/
                    if (array_key_exists('tagid_list', $userTags)) {

                        if (count($userTags['tagid_list'])) {


                            /*移除不需要的标签id*/
                            foreach ($userTags['tagid_list'] as $tagId) {

                                if ($user_tagId != $tagId) {

                                    $officialAccount->user_tag->untagUsers([$open_id], $tagId);

                                }

                            }

                        }

                        if (!in_array($user_tagId, $userTags['tagid_list'])) {

                            /*为用户打标签*/
                            $officialAccount->user_tag->tagUsers([$open_id], $user_tagId);
                        }

                        /*发送微信模板消息*/
                        if (config('comm.send_report_event')) {

                            \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                                ->dispatch(new BangdingEvent($user, $client));
                        }

                        \DB::commit();

                        Cache::forget($cace_sms_code);
                        return success_simple_respone();

                    } else {

                        \DB::rollback();
                        return error_simple_respone('请先关注优企康平台公众号');
                    }


                } else {

                    \DB::rollback();
                    return error_simple_respone('验证码错误');

                }

            }

        } catch (Exception $exception) {

            \DB::rollback();
            report($exception);
            throw new CheckSmsCodeFailedException();

        }
    }


}
