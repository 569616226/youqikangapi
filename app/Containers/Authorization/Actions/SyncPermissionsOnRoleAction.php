<?php

namespace App\Containers\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Request;

/**
 * Class SyncPermissionsOnRoleAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class SyncPermissionsOnRoleAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {
        $role = Apiato::call('Authorization@FindRoleTask', [$request->role_id]);

        $permissions = [];

        if (is_array($permissionsIds = $request->permissions_ids)) {

            foreach ($permissionsIds as $permissionId) {

                $permissions[] = Apiato::call('Authorization@FindPermissionTask', [$permissionId]);

            }

        } else {

            $permissions[] = Apiato::call('Authorization@FindPermissionTask', [$permissionsIds]);

        }

        try {

            \DB::beginTransaction();

            $role = Apiato::call('Authorization@UpdateRoleTask', [
                [
                    'name'         => $request->name,
                    'display_name' => $request->display_name,
                ]
                , $role->id
            ]);

            $role->syncPermissions($permissions);

            \DB::commit();

            return $role;

        } catch (Exception $exception) {

            \DB::rollback();
            throw $exception;

        }

    }
}
