<?php

namespace App\Containers\Settings\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Settings\UI\API\Requests\CreateSettingRequest;
use App\Containers\Settings\UI\API\Requests\DeleteSettingRequest;
use App\Containers\Settings\UI\API\Requests\FindWechatSettingRequest;
use App\Containers\Settings\UI\API\Requests\GetAllSettingsRequest;
use App\Containers\Settings\UI\API\Requests\SetWechatSettingRequest;
use App\Containers\Settings\UI\API\Transformers\SettingTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Controller extends ApiController
{

    /**
     * Get All application settings
     *
     * @param GetAllSettingsRequest $request
     *
     * @return mixed
     */
    public function getAllSettings(GetAllSettingsRequest $request)
    {
        $settings = Apiato::call('Settings@GetAllSettingsAction', [$request]);

        return $this->transform($settings, SettingTransformer::class);
    }

    /**
     * create a new setting
     *
     * @param CreateSettingRequest $request
     *
     * @return mixed
     */
    public function createSetting(CreateSettingRequest $request)
    {
        $setting = Apiato::call('Settings@CreateSettingAction', [$request]);

        return $this->transform($setting, SettingTransformer::class);
    }

    /**
     * set an existing setting
     *
     * @param SetWechatSettingRequest $request
     *
     * @return mixed
     */
    public function setWechatSetting(SetWechatSettingRequest $request)
    {
        $setting = Apiato::call('Settings@SetWechatSettingAction', [$request]);

        if ($setting) {
            return success_simple_respone();
        } else {
            return error_simple_respone();
        }

    }


    /**
     * find an existing setting
     *
     * @param FindWechatSettingRequest $request
     *
     * @return mixed
     */
    public function findWechatSetting(FindWechatSettingRequest $request)
    {
        $setting = Apiato::call('Settings@FindWechatSettingAction', [$request]);

        return $this->transform($setting, SettingTransformer::class);

    }

    /**
     * Removes a setting
     *
     * @param DeleteSettingRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSetting(DeleteSettingRequest $request)
    {
        $setting = Apiato::call('Settings@DeleteSettingAction', [$request]);

        return $this->noContent();
    }
}
