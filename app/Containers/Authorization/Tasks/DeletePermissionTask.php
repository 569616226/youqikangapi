<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\Authorization\Models\Permission;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\App;

/**
 * Class DeleteRoleTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeletePermissionTask extends Task
{
    /**
     * @param Integer|Permission $permission
     *
     * @return  bool
     */
    public function run($permission)
    {
        if ($permission instanceof Permission) {
            $permission = $permission->id;
        }

        // delete the record from the roles table.
        return App::make(PermissionRepository::class)->delete($permission);
    }
}
