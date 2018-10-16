<?php

namespace App\Containers\Order\UI\API\Tests\Mobile\Functional;

use App\Containers\Authorization\Models\Role;
use App\Containers\Order\Tests\TestCase;

/**
 * Class FindOrderTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindMobileOrderTest extends TestCase
{

    protected $endpoint = 'get@v1/mobile/orders/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testFindMobileOrderById_()
    {
        $this->getTestingUser([
            'username' => '系统'
        ]);

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $report_name = $this->order->reports->isEmpty() ? $this->order->name : $this->order->reports()->latest()->first()->name;

        $this->assertEquals($report_name, $responseContent->data->name);
        $this->assertEquals($this->order->status, $responseContent->data->status);

        $this->assertNotNull($responseContent->data->plan);
        $this->assertFalse($responseContent->data->plan->data->is_finish);

        $plan_depart = $responseContent->data->plan->data->plan_departs->data[0];
        $this->assertNotNull($plan_depart->name);
        $this->assertNotNull($plan_depart->icon);
        $this->assertNotNull($plan_depart->auditings);
        $this->assertNotNull($plan_depart->complates);
        $this->assertNotNull($plan_depart->all_counts);
        $this->assertNotNull($plan_depart->is_finish);
    }

    public function testFindMobileOrderWithAuditerById_()
    {
        $this->getTestingUser([
            'username' => '系统',
            'is_audit' => true,
        ]);

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $report_name = $this->order->reports->isEmpty() ? $this->order->name : $this->order->reports()->latest()->first()->name;

        $this->assertEquals($report_name, $responseContent->data->name);
        $this->assertEquals($this->order->status, $responseContent->data->status);

        $this->assertNotNull($responseContent->data->plan);
        $this->assertFalse($responseContent->data->plan->data->is_finish);

        $plan_depart = $responseContent->data->plan->data->plan_departs->data[0];
        $this->assertNotNull($plan_depart->name);
        $this->assertNotNull($plan_depart->icon);
        $this->assertNotNull($plan_depart->auditings);
        $this->assertNotNull($plan_depart->complates);
        $this->assertNotNull($plan_depart->all_counts);
        $this->assertNotNull($plan_depart->is_finish);
    }

}
