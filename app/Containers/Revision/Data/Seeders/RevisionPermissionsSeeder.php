<?php

namespace App\Containers\Revision\Data\Seeders;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class RevisionPermissionsSeeder
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class RevisionPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Permissions ----------------------------------------------------------
        Apiato::call('Authorization@CreatePermissionTask', ['list-logs', '系统日志列表']);
        // ...

    }
}
