<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Models\Order;
use App\Containers\Order\Tests\TestCase;

/**
 * Class DeleteOrderTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteOrderTest extends TestCase
{

    protected $endpoint = 'delete@v1/orders/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];

    public function testDeleteExistingOrder_()
    {

        $this->getTestingUser();

        $revisionHistory = $this->order->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '订单删除成功',
        ]);

        $deleted_order = Order::withTrashed()->find($this->order->id);

        $this->assertCount($revisionHistory + 1, $deleted_order->revisionHistory);
    }

    public function testDeleteExistingOrderError_()
    {

        $this->getTestingUser();

        $order = factory(Order::class)->create([
            'status'     => '进行中',
            'plan_id'    => $this->plan->id,
            'company_id' => $this->company->id,
        ]);

        $revisionHistory = $order->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '不能删除进行中的订单',
        ]);

        $deleted_order = Order::withTrashed()->find($order->id);

        $this->assertCount($revisionHistory, $deleted_order->revisionHistory);
    }

}
