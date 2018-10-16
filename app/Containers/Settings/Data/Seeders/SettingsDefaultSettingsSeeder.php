<?php

namespace App\Containers\Settings\Data\Seeders;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Settings\Models\Setting;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class SettingsDefaultSettingsSeeder
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class SettingsDefaultSettingsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = new Setting();
        $settings->key = 'wechat';
        $settings->value = '优企康，让我们的企业更健康！我们是一个覆盖过千家进出口企业的风险管理平台，专注于为企业提供从订单，生产管理，到物流，关务，财务等环节的风险管理一体化解决方案。';
        $settings->save();


        Apiato::call('Authorization@CreatePermissionTask', ['manage-wechat_setting', '公众号管理']);
    }
}
