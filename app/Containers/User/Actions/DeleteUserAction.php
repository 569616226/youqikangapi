<?php

namespace App\Containers\User\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class DeleteUserAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteUserAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {

        if ($request->id) {
            $user = Apiato::call('User@FindUserByIdTask', [$request->id]);
        } else {
            $user = Apiato::call('Authentication@GetAuthenticatedUserTask');
        }

        if (!$user->is_client && $user->is_audit) {//后台审核人
            return error_simple_respone('不能删除项目审核人');
        } elseif ($user->is_client && $user->is_client_admin) {//企业主
            return error_simple_respone('不能删除企业主');
        } else {
            $result = Apiato::call('User@DeleteUserTask', [$user->id]);
            if ($result) {
                return success_simple_respone($user->username . ' 用户删除成功');
            } else {
                return error_simple_respone();
            }
        }


    }
}
