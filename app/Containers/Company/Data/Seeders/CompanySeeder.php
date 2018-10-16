<?php

namespace App\Containers\Company\Data\Seeders;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Company\Models\Company;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class UserPermissionsSeeder_1
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Permissions ----------------------------------------------------------
        Apiato::call('Authorization@CreatePermissionTask', ['manage-companies', '客户列表']);

        factory(Company::class, 20)->create();
        // ...

    }
}
