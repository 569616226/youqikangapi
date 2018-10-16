<?php

namespace App\Containers\Settings\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class DeleteSettingAction
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class DeleteSettingAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {
        $setting = Apiato::call('Settings@FindSettingByIdTask', [$request->id]);

        $result = Apiato::call('Settings@DeleteSettingTask', [$setting]);

        return $result;
    }
}
