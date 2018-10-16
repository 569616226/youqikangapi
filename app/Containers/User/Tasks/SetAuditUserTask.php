<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Events\SetAuditUserEvent;
use App\Containers\User\Models\User;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\App;

/**
 * Class UpdateUserTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class SetAuditUserTask extends Task
{

    /**
     * @return mixed
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($userId)
    {

        try {

            \DB::beginTransaction();

            $users = App::make(User::class)->where('is_audit', true)->get();

            if (!$users->isEmpty()) {

                App::make(User::class)->where('is_audit', true)->update(['is_audit' => false]);

                foreach ($users as $u) {

                    if (config('comm.send_audit_user_event')) {
                        \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                            ->dispatch(new SetAuditUserEvent($u));
                    }

                }

            }

            $user = App::make(UserRepository::class)->update(['is_audit' => true], $userId);

            if ($user) {

                if (config('comm.send_audit_user_event')) {
                    \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                        ->dispatch(new SetAuditUserEvent($user));
                }

                \DB::commit();

                return $user;

            } else {

                \DB::rollback();

                return false;
            }

        } catch (Exception $exception) {

            \DB::rollback();
            report($exception);
            throw new InternalErrorException();
        }


    }

}
