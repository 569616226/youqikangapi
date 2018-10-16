<?php

namespace App\Containers\Welcome\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class HomePageAction extends Action
{

    /**
     * @return  array
     */
    public function run()
    {
        return Apiato::call('Welcome@HomePageTask');
    }
}
