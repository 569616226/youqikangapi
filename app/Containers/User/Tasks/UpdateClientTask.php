<?php

namespace App\Containers\User\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Events\SetClientAdminUserEvent;
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
class UpdateClientTask extends Task
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
    public function run($userData, $userId, $companyId)
    {
        if (empty($userData)) {
            throw new UpdateResourceFailedException('Inputs are empty.');
        }

        try {

            \DB::beginTransaction();

            $other_user = Apiato::call('User@FindUserByPhoneTask', [$userData['phone']]);
            if ($other_user && $other_user->id != $userId) {

                return error_simple_respone('此手机号码已被使用');

            }

            $user = App::make(UserRepository::class)->update($userData, $userId);


            $user->companies()->sync($companyId);

            if(config('comm.send_set_client_admin_user_event')){
                \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                    ->dispatch(new SetClientAdminUserEvent($user));

            }

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
