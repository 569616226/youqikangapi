<?php

namespace App\Containers\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateRoleAction
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class CreateRoleAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {
        $level = $request->has('level') ? $request->level : 0;

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

            $role = Apiato::call('Authorization@CreateRoleTask',
                [$request->name, $request->description, $request->display_name, $level]
            );

            $role->syncPermissions($permissions);

            \DB::commit();

            return $role;

        } catch (Exception $exception) {

            \DB::rollback();
            throw $exception;

        }
    }
}
