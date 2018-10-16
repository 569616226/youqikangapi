<?php

namespace App\Containers\Authorization\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authorization\UI\API\Requests\CreatePermissionRequest;
use App\Containers\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Containers\Authorization\UI\API\Requests\DeletePermissionRequest;
use App\Containers\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Containers\Authorization\UI\API\Requests\FindPermissionRequest;
use App\Containers\Authorization\UI\API\Requests\FindRoleRequest;
use App\Containers\Authorization\UI\API\Requests\GetAllPermissionsRequest;
use App\Containers\Authorization\UI\API\Requests\GetAllRolesRequest;
use App\Containers\Authorization\UI\API\Requests\SyncPermissionsOnRoleRequest;
use App\Containers\Authorization\UI\API\Requests\UpdatePermissionRequest;
use App\Containers\Authorization\UI\API\Transformers\PermissionTransformer;
use App\Containers\Authorization\UI\API\Transformers\RoleTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class Controller extends ApiController
{

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\GetAllPermissionsRequest $request
     *
     * @return  mixed
     */
    public function getAllPermissions(GetAllPermissionsRequest $request)
    {
        $permissions = Apiato::call('Authorization@GetAllPermissionsAction');

        return $this->transform($permissions, PermissionTransformer::class);
    }

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\FindPermissionRequest $request
     *
     * @return  mixed
     */
    public function findPermission(FindPermissionRequest $request)
    {
        $permission = Apiato::call('Authorization@FindPermissionAction', [$request]);

        return $this->transform($permission, PermissionTransformer::class);
    }

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\GetAllRolesRequest $request
     *
     * @return  mixed
     */
    public function getAllRoles(GetAllRolesRequest $request)
    {
        $roles = Apiato::call('Authorization@GetAllRolesAction');

        return $this->transform($roles, RoleTransformer::class);
    }

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\FindRoleRequest $request
     *
     * @return  mixed
     */
    public function findRole(FindRoleRequest $request)
    {
        $role = Apiato::call('Authorization@FindRoleAction', [$request]);

        return $this->transform($role, RoleTransformer::class);
    }


    /**
     * @param \App\Containers\Authorization\UI\API\Requests\DeleteRoleRequest $request
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function deleteRole(DeleteRoleRequest $request)
    {
        return Apiato::call('Authorization@DeleteRoleAction', [$request]);

    }

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\DeletePermissionRequest $request
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function deletePermission(DeletePermissionRequest $request)
    {
        $permission = Apiato::call('Authorization@DeletePermissionAction', [$request]);

        if ($permission) {
            return success_simple_respone($permission->display_name . ' 权限删除成功');
        } else {
            return error_simple_respone();
        }
    }


    /**
     * @param \App\Containers\Authorization\UI\API\Requests\SyncPermissionsOnRoleRequest $request
     *
     * @return  mixed
     */
    public function syncPermissionOnRole(SyncPermissionsOnRoleRequest $request)
    {
        $role = Apiato::call('Authorization@SyncPermissionsOnRoleAction', [$request]);

        if ($role) {
            return success_simple_respone();
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\CreateRoleRequest $request
     *
     * @return  mixed
     */
    public function createRole(CreateRoleRequest $request)
    {
        $role = Apiato::call('Authorization@CreateRoleAction', [$request]);

        if ($role) {
            return success_simple_respone($role->display_name . ' 角色新建成功');
        } else {
            return error_simple_respone();
        }

    }

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\CreatePermissionRequest $request
     *
     * @return  mixed
     */
    public function createPermission(CreatePermissionRequest $request)
    {
        $permission = Apiato::call('Authorization@CreatePermissionAction', [$request]);

        if ($permission) {
            return success_simple_respone($permission->display_name . ' 权限新建成功');
        } else {
            return error_simple_respone();
        }

    }

    /**
     * @param \App\Containers\Authorization\UI\API\Requests\UpdatePermissionRequest $request
     *
     * @return  mixed
     */
    public function updatePermission(UpdatePermissionRequest $request)
    {
        $permission = Apiato::call('Authorization@UpdatePermissionAction', [$request]);

        if ($permission) {
            return success_simple_respone('权限更新成功');
        } else {
            return error_simple_respone();
        }

    }

}
