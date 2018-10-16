<?php

namespace App\Containers\Company\Tests;

use App\Containers\Company\Models\Company;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\Models\Plan;
use App\Containers\Report\Models\Report;
use App\Containers\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase as ShipTestCase;

/**
 * Class TestCase
 *
 * Container TestCase class. Use this class to put your container specific tests helper functions.
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class TestCase extends ShipTestCase
{
    protected $company;
    protected $userB;
    protected $company_last;
    protected $plan_1;
    protected $plan_2;
    protected $order;
    protected $order_1;
    protected $report;

    public function setUp()
    {
        parent::setUp();
        $this->company = factory(Company::class)->create([
            'logo'       => $this->faker->imageUrl(80, 80),
            'created_at' => now()
        ]);

        $this->company_last = factory(Company::class)->create([
            'logo'       => $this->faker->imageUrl(80, 80),
            'created_at' => now()->addMonth()
        ]);

        $this->userB = factory(User::class)->create([
            'username'  => $this->faker->name,
            'is_client' => true,
        ]);

        $this->userA = factory(User::class)->create([
            'is_client' => true,
            'username'  => $this->faker->name,
        ]);

        $this->plan_1 = factory(Plan::class)->create([
            'name' => 'plan'
        ]);

        $this->plan_2 = factory(Plan::class)->create([
            'name' => 'plan'
        ]);

        $this->order = factory(Order::class)->create([
            'status'     => '已完成',
            'company_id' => $this->company_last->id,
            'plan_id'    => $this->plan_1->id,
        ]);

        $this->order_1 = factory(Order::class)->create([
            'status'     => '已完成',
            'company_id' => $this->company->id,
            'plan_id'    => $this->plan_2->id,
        ]);

        $this->report = factory(Report::class)->create([
            'order_id' => $this->order->id
        ]);

        factory(Report::class)->create([
            'order_id' => $this->order_1->id
        ]);
    }
}
