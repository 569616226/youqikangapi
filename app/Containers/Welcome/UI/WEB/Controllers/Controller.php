<?php

namespace App\Containers\Welcome\UI\WEB\Controllers;

use App\Ship\Parents\Controllers\WebController;
use Illuminate\Support\Facades\Cache;

/**
 * Class Controller.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class Controller extends WebController
{

    /**
     * @return  \Illuminate\Http\JsonResponse
     */
    public function refreshCaches()
    {

      Cache::flush();

      echo '清除缓存成功';

    }

}
