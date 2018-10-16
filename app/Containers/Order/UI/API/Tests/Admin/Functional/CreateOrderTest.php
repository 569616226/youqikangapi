<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Models\Order;
use App\Containers\Order\Tests\TestCase;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateOrderTest extends TestCase
{

    protected $endpoint = 'post@v1/orders';

    protected $auth = true;

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];

    public function testCreateOrderStart_()
    {
        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $data = [
            'name'       => $this->faker->name,
            'status'     => '进行中',
            'plan_id'    => $this->plan->getHashedKey(),
            'company_id' => $this->company->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $data['name'] . ' 订单新建成功',
        ]);

        $order = Order::whereName($data['name'])->latest()->first();

        $this->assertEquals('进行中', $order->status);
        $this->assertNotNull($order->start_at);
        $this->assertCount(1, $order->plan->plan_departs);
        $plan_depart_questions = 0;
        foreach ($order->plan->plan_departs as $plan_depart) {
            $plan_depart_questions += $plan_depart->plan_depart_questions->count();
        }
        $this->assertEquals(20, $plan_depart_questions);
        $this->assertCount(1, $order->revisionHistory);

    }

    public function testCreateOrderDontStart_()
    {
        $this->getTestingUser([
            'username' => 'admin'
        ]);


        $data = [
            'name'       => $this->faker->name,
            'status'     => '未开始',
            'plan_id'    => $this->plan->getHashedKey(),
            'company_id' => $this->company->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $data['name'] . ' 订单新建成功',
        ]);

        $order = Order::whereName($data['name'])->latest()->first();

        $this->assertEquals('未开始', $order->status);
        $this->assertNull($order->start_at);
        $this->assertCount(1, $order->plan->plan_departs);
        $plan_depart_questions = 0;
        foreach ($order->plan->plan_departs as $plan_depart) {
            $plan_depart_questions += $plan_depart->plan_depart_questions->count();
        }
        $this->assertEquals(20, $plan_depart_questions);
        $this->assertCount(1, $order->revisionHistory);

    }

}
