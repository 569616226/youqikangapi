<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Models\Order;
use App\Containers\Order\Tests\TestCase;

/**
 * Class UpdateOrderTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateOrderTest extends TestCase
{

    protected $endpoint = 'patch@v1/orders/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];

    public function testUpdateExistingOrder_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->order->revisionHistory->count();

        $data = [
            'name' => 'update#manager',
        ];

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '订单更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('orders', [
            'name' => $data['name'],
        ]);

        $update_order = Order::find($this->order->id);

        $this->assertEquals($update_order->name, $data['name']);

        $this->assertCount($revisionHistory + 1, $update_order->revisionHistory);
    }

}


