<?php

namespace App\Containers\Settings\Data\Seeders;

use App\Ship\Parents\Seeders\Seeder;

/**
 * Class AuthorizationRolesSeeder_2
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class OauthClientsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default OauthClients ----------------------------------------------------------------
        \DB::table('oauth_clients')->insert([
            [
                'id'                     => 1,
                'user_id'                => null,
                'name'                   => 'youqikang',
                'secret'                 => 'Q19npFNu2g0dqxWfeOdTjVdzZC2mZR0DiLw6036C',
                'redirect'               => 'http://localhost',
                'personal_access_client' => 1,
                'password_client'        => 0,
                'revoked'                => 0,
                'created_at'             => now(),
                'updated_at'             => now(),
            ], [
                'id'                     => 2,
                'user_id'                => null,
                'name'                   => 'youqikang',
                'secret'                 => 'fTlILPsuIjV6nxHb3rqE4otU4XdTJA98RjZw2C4B',
                'redirect'               => 'http://localhost',
                'personal_access_client' => 0,
                'password_client'        => 1,
                'revoked'                => 0,
                'created_at'             => now(),
                'updated_at'             => now(),
            ],
        ]);

        // ...

    }
}
