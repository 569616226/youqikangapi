<?php

namespace App\Containers\User\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Containers\User\UI\API\Requests\CreateAdminRequest;
use App\Containers\User\UI\API\Requests\CreateClientRequest;
use App\Containers\User\UI\API\Requests\DeleteUserRequest;
use App\Containers\User\UI\API\Requests\FindClientByIdRequest;
use App\Containers\User\UI\API\Requests\FindUserByIdRequest;
use App\Containers\User\UI\API\Requests\ForgotPasswordRequest;
use App\Containers\User\UI\API\Requests\FrozenUserRequest;
use App\Containers\User\UI\API\Requests\GetAllUsersRequest;
use App\Containers\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Containers\User\UI\API\Requests\ResetPasswordRequest;
use App\Containers\User\UI\API\Requests\SetAuditUserRequest;
use App\Containers\User\UI\API\Requests\UpdateClientRequest;
use App\Containers\User\UI\API\Requests\UpdateUserPasswordRequest;
use App\Containers\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\User\UI\API\Transformers\ClientTransformer;
use App\Containers\User\UI\API\Transformers\UserPrivateProfileTransformer;
use App\Containers\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class Controller extends ApiController
{
    /**
     * @param \App\Containers\User\UI\API\Requests\CreateAdminRequest $request
     *
     * @return  mixed
     */
    public function createAdmin(CreateAdminRequest $request)
    {
        $admin = Apiato::call('User@CreateAdminAction', [$request]);

        if ($admin) {
            if ($admin instanceof User) {
                return success_simple_respone($admin->username . ' 用户创建成功');
            } else {
                return $admin;
            }

        } else {
            return error_simple_respone();
        }

    }

    /**
     * @param \App\Containers\User\UI\API\Requests\CreateClientRequest $request
     *
     * @return  mixed
     */
    public function createClient(CreateClientRequest $request)
    {
        $user = Apiato::call('User@CreateClientAction', [$request]);

        if ($user) {
            if ($user instanceof User) {
                return success_simple_respone($user->username . ' 联系人创建成功');
            } else {
                return $user;
            }
        } else {
            return error_simple_respone();
        }

    }

    /**
     * @param \App\Containers\User\UI\API\Requests\UpdateUserRequest $request
     *
     * @return  mixed
     */
    public function updateUser(UpdateUserRequest $request)
    {
        $admin = Apiato::call('User@UpdateUserAction', [$request]);

        if ($admin) {

            if ($admin instanceof User) {

                return success_simple_respone('用户更新成功');

            } else {

                return $admin;
            }

        } else {

            return error_simple_respone();
        }
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\UpdateClientRequest $request
     *
     * @return  mixed
     */
    public function updateClient(UpdateClientRequest $request)
    {
        $user = Apiato::call('User@UpdateClientAction', [$request]);

        if ($user) {

            if ($user instanceof User) {

                return success_simple_respone('用户更新成功');

            } else {

                return $user;
            }

        } else {

            return error_simple_respone();

        }
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\UpdateUserRequest $request
     *
     * @return  mixed
     */
    public function updateUserPassword(UpdateUserPasswordRequest $request)
    {
        $user = Apiato::call('User@UpdateUserPasswordAction', [$request]);

        if ($user) {
            return success_simple_respone($user->username . ' 用户密码更新成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\UpdateUserRequest $request
     *
     * @return  mixed
     */
    public function frozenUser(FrozenUserRequest $request)
    {
        $user = Apiato::call('User@FrozenUserAction', [$request]);

        if ($user && $user->is_frozen) {
            return success_simple_respone($user->username . ' 用户冻结成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\UpdateUserRequest $request
     *
     * @return  mixed
     */
    public function refrozenUser(FrozenUserRequest $request)
    {
        $user = Apiato::call('User@reFrozenUserAction', [$request]);

        if ($user && !$user->is_frozen) {
            return success_simple_respone($user->username . ' 用户解冻成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\SetAuditUserRequest $request
     *
     * @return  mixed
     */
    public function setAuditUser(SetAuditUserRequest $request)
    {
        $user = Apiato::call('User@SetAuditUserAction', [$request]);

        if ($user && $user->is_audit) {
            return success_simple_respone('设置成功');
        } else {
            return error_simple_respone('设置失败');
        }
    }


    /**
     * @param \App\Containers\User\UI\API\Requests\DeleteUserRequest $request
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function deleteUser(DeleteUserRequest $request)
    {
        return Apiato::call('User@DeleteUserAction', [$request]);
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\GetAllUsersRequest $request
     *
     * @return  mixed
     */
    public function getAllUsers(GetAllUsersRequest $request)
    {
        $users = Apiato::call('User@GetAllUsersAction');

        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\GetAllUsersRequest $request
     *
     * @return  mixed
     */
    public function getAllClients(GetAllUsersRequest $request)
    {
        $users = Apiato::call('User@GetAllClientsAction');

        return $this->transform($users, ClientTransformer::class);
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\GetAllUsersRequest $request
     *
     * @return  mixed
     */
    public function getAllAdmins(GetAllUsersRequest $request)
    {
        $users = Apiato::call('User@GetAllAdminsAction');

        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\FindUserByIdRequest $request
     *
     * @return  mixed
     */
    public function findUserById(FindUserByIdRequest $request)
    {
        $user = Apiato::call('User@FindUserByIdAction', [$request]);

        return $this->transform($user, UserTransformer::class);
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\FindClientByIdRequest $request
     *
     * @return  mixed
     */
    public function findClientById(FindClientByIdRequest $request)
    {
        $user = Apiato::call('User@FindUserByIdAction', [$request]);

        return $this->transform($user, ClientTransformer::class);
    }

    /**
     * @param GetAuthenticatedUserRequest $request
     *
     * @return mixed
     */
    public function getAuthenticatedUser(GetAuthenticatedUserRequest $request)
    {
        $user = Apiato::call('User@GetAuthenticatedUserAction', [$request]);

        return $this->transform($user, UserPrivateProfileTransformer::class);
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\ResetPasswordRequest $request
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        Apiato::call('User@ResetPasswordAction', [$request]);

        return $this->noContent(204);
    }

    /**
     * @param \App\Containers\User\UI\API\Requests\ForgotPasswordRequest $request
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        Apiato::call('User@ForgotPasswordAction', [$request]);

        return $this->noContent(202);
    }

}
