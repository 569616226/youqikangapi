<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\RoleRepository;
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
class UpdateRoleTask extends Task
{

    /**
     * @param $roleData
     * @param $roleId
     *
     * @return mixed
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($roleData, $roleId)
    {
        if (empty($roleData)) {
            throw new UpdateResourceFailedException('Inputs are empty.');
        }

        try {

            $role = App::make(RoleRepository::class)->update($roleData, $roleId);

        } catch (ModelNotFoundException $exception) {

            throw new NotFoundException('Role Not Found.');

        } catch (Exception $exception) {

            throw new InternalErrorException();
        }

        return $role;
    }

}
