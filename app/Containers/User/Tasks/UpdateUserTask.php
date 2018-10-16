<?php

namespace App\Containers\User\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Data\Repositories\UserRepository;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;

/**
 * Class UpdateUserTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateUserTask extends Task
{

    /**
     * @param $userData
     * @param $userId
     *
     * @return mixed
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($userData, $userId, $roleId)
    {
        if (empty($userData)) {
            throw new UpdateResourceFailedException('Inputs are empty.');
        }

        try {

            $other_user = Apiato::call('User@FindUserByPhoneTask', [$userData['phone']]);
            if ($other_user && $other_user->id != $userId) {

                return error_simple_respone('此手机号码已被使用');

            }

            \DB::beginTransaction();

            $user = App::make(UserRepository::class)->update($userData, $userId);

            $user->syncRoles($roleId);

            \DB::commit();

            return $user;

        } catch (ModelNotFoundException $exception) {

            \DB::rollback();
            report($exception);
            throw new NotFoundException('User Not Found.');

        } catch (Exception $exception) {

            \DB::rollback();
            report($exception);
            throw new InternalErrorException();
        }


    }

}
