<?php

namespace App\Containers\Authorization\Data\Seeders;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class AuthorizationDefaultUsersSeeder_3
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class AuthorizationDefaultUsersSeeder_3 extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Users (with their roles) ---------------------------------------------
        $role = Apiato::call('Authorization@FindRoleTask', ['admin']);
        Apiato::call('User@CreateUserByCredentialsTask', [
            $isClient = false,
            'admin',
            'Super Admin',
            '13412081338',
            'admin',
            $role->id,
        ]);

        // ...

    }
}
