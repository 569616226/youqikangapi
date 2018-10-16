<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Models\Order;
use App\Containers\Order\Tests\TestCase;

/**
 * Class UpdateOrderTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class reFrozenOrderTest extends TestCase
{

    protected $endpoint = 'get@v1/orders/{id}/refrozen';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];

    public function testreFrozenExistingOrder_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->order->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '订单解冻成功',
        ]);

        $update_order = Order::find($this->order->id);

        $this->assertEquals('进行中',$update_order->status);

        $this->assertCount($revisionHistory + 1, $update_order->revisionHistory);
    }

}


