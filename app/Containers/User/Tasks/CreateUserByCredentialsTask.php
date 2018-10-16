<?php

namespace App\Containers\User\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Data\Repositories\UserRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

/**
 * Class CreateUserByCredentialsTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateUserByCredentialsTask extends Task
{

    /**
     * @param bool $isClient
     * @param      $password
     * @param      $name
     * @param      $phone
     * @param      $username
     * @param      $roleId
     *
     * @return mixed
     * @throws CreateResourceFailedException
     */
    public function run($isClient = true, $password, $name, $phone, $username, $roleId)
    {
        try {

            \DB::beginTransaction();


            $user = Apiato::call('User@FindUserByPhoneTask', [$phone]);
            if ($user) {
                return error_simple_respone('此手机号码已被使用');
            }

            // create new user
            $user = App::make(UserRepository::class)->create([
                'password'  => Hash::make($password),
                'name'      => $name,
                'username'  => $username,
                'phone'     => $phone,
                'is_client' => $isClient,
            ]);

            $user->syncRoles($roleId);

            \DB::commit();

            return $user;

        } catch (Exception $e) {

            throw (new CreateResourceFailedException())->debug($e);

        }

    }

}
