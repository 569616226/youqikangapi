<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Models\Order;
use App\Containers\Order\Tests\TestCase;

/**
 * Class UpdateOrderTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class StartOrderTest extends TestCase
{

    protected $endpoint = 'patch@v1/orders/{id}/start';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];

    public function testStartExistingOrder_()
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
            'msg'    => '订单启动成功',
        ]);

        $update_order = Order::find($this->order->id);

        $this->assertNotNull($update_order->start_at);
        $this->assertEquals('进行中',$update_order->status);

        $this->assertCount($revisionHistory + 1, $update_order->revisionHistory);
    }

}


