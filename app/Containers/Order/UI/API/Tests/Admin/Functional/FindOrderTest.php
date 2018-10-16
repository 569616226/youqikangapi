<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Tests\TestCase;

/**
 * Class FindOrderTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindOrderTest extends TestCase
{

    protected $endpoint = 'get@v1/orders/{id}?include=company,plan';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];

    public function testFindOrderById_()
    {
        $this->getTestingUser([
            'username' => '系统'
        ]);

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $report_create_at = $this->order->reports->isEmpty() ? '暂无报告' : $this->order->reports()->latest()->first()->created_at->toDateTimeString();
        $start_at = $this->order->start_at ? $this->order->start_at->toDateTimeString() : null;

        $this->assertEquals($this->order->name, $responseContent->data->name);
        $this->assertEquals($this->order->status, $responseContent->data->status);
        $this->assertEquals($report_create_at, $responseContent->data->report_create_at);
        $this->assertEquals($this->order->company->name, $responseContent->data->company_name);
        $this->assertEquals($this->order->plan->name, $responseContent->data->plan_name);
        $this->assertEquals($this->order->order_number, $responseContent->data->order_number);
        $this->assertEquals($start_at, $responseContent->data->start_at);

        $this->assertNotNull($responseContent->data->plan);
        $this->assertNotNull($responseContent->data->company);
    }

}
