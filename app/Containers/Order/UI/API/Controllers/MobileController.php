<?php

namespace App\Containers\Order\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Order\UI\API\Requests\Mobile\FindMobileOrderByIdRequest;
use App\Containers\Order\UI\API\Transformers\Mobile\MobileOrderTransformer;
use App\Containers\Order\UI\API\Transformers\OrderTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\Order\UI\API\Controllers
 */
class MobileController extends ApiController
{

    /**
     * @param FindMobileOrderByIdRequest $request
     * @return array
     */
    public function findMobileOrderById(FindMobileOrderByIdRequest $request)
    {
        $order = Apiato::call('Order@FindOrderByIdAction', [$request]);

        return $this->transform($order, MobileOrderTransformer::class);
    }


}
