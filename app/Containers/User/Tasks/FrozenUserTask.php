<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Events\FrozenUserEvent;
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
class FrozenUserTask extends Task
{

    /**
     * @return mixed
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($is_frozen, $userId)
    {

        try {

            $user = App::make(UserRepository::class)->update(['is_frozen' => $is_frozen], $userId);

            if($user->is_frozen == $is_frozen){

                if(config('comm.send_frozen_user_event')){
                    \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                        ->dispatch(new FrozenUserEvent($user));
                }

                return $user;

            }else{
                return false;
            }




        } catch (ModelNotFoundException $exception) {

            throw new NotFoundException('User Not Found.');

        } catch (Exception $exception) {

            throw new InternalErrorException();
        }


    }

}
