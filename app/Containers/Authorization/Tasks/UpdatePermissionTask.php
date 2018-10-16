<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\PermissionRepository;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;

/**
 * Class UpdateRolTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdatePermissionTask extends Task
{

    /**
     * @param $permissionData
     * @param $permissionId
     *
     * @return mixed
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($permissionData, $permissionId)
    {
        if (empty($permissionData)) {
            throw new UpdateResourceFailedException('Inputs are empty.');
        }

        try {

            $permission = App::make(PermissionRepository::class)->update($permissionData, $permissionId);

        } catch (ModelNotFoundException $exception) {

            throw new NotFoundException('Permission Not Found.');

        } catch (Exception $exception) {

            throw new InternalErrorException();
        }

        return $permission;
    }

}
