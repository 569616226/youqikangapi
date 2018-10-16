<?php

namespace App\Containers\Order\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Order\UI\API\Requests\CreateOrderRequest;
use App\Containers\Order\UI\API\Requests\CreateOrderWithCreateNewPlanRequest;
use App\Containers\Order\UI\API\Requests\DeleteOrderRequest;
use App\Containers\Order\UI\API\Requests\FindOrderByIdRequest;
use App\Containers\Order\UI\API\Requests\GetAllOrdersRequest;
use App\Containers\Order\UI\API\Requests\StartOrderRequest;
use App\Containers\Order\UI\API\Requests\UpdateOrderRequest;
use App\Containers\Order\UI\API\Transformers\Mobile\MobileOrderTransformer;
use App\Containers\Order\UI\API\Transformers\OrderTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\Order\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreateOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(CreateOrderRequest $request)
    {
        $order = Apiato::call('Order@CreateOrderAction', [$request]);

        if ($order) {
            return success_simple_respone($order->name . ' 订单新建成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param CreateOrderWithCreateNewPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrderWithCreateNewPlan(CreateOrderWithCreateNewPlanRequest $request)
    {
        $order = Apiato::call('Order@CreateOrderWithCreateNewPlanAction', [$request]);

        if ($order) {
            return success_simple_respone($order->name . ' 订单新建成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param FindOrderByIdRequest $request
     * @return array
     */
    public function findOrderById(FindOrderByIdRequest $request)
    {
        $order = Apiato::call('Order@FindOrderByIdAction', [$request]);

        return $this->transform($order, OrderTransformer::class);
    }

    /**
     * @param GetAllOrdersRequest $request
     * @return array
     */
    public function getAllOrders(GetAllOrdersRequest $request)
    {
        $orders = Apiato::call('Order@GetAllOrdersAction', [$request]);

        return $this->transform($orders, OrderTransformer::class);
    }

    /**
     * @param UpdateOrderRequest $request
     * @return array
     */
    public function updateOrder(UpdateOrderRequest $request)
    {
        $order = Apiato::call('Order@UpdateOrderAction', [$request]);

        if ($order) {
            return success_simple_respone('订单更新成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param StartOrderRequest $request
     * @return array
     */
    public function startOrder(StartOrderRequest $request)
    {
        $order = Apiato::call('Order@StartOrderAction', [$request]);

        if ($order->start_at && $order->status == '进行中') {
            return success_simple_respone('订单启动成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param StartOrderRequest $request
     * @return array
     */
    public function frozenOrder(StartOrderRequest $request)
    {
        $order = Apiato::call('Order@FrozenOrderAction', [$request]);

        if ($order->status == '已冻结') {
            return success_simple_respone('订单冻结成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param StartOrderRequest $request
     * @return array
     */
    public function refrozenOrder(StartOrderRequest $request)
    {
        $order = Apiato::call('Order@reFrozenOrderAction', [$request]);

        if ($order->status == '进行中') {
            return success_simple_respone('订单解冻成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param DeleteOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOrder(DeleteOrderRequest $request)
    {
        return Apiato::call('Order@DeleteOrderAction', [$request]);

    }
}
