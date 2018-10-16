<?php

namespace App\Containers\Order\Tests;

use App\Containers\Company\Models\Company;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\Models\Plan;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\Models\QuestionDetail;
use App\Containers\Report\Models\Report;
use App\Containers\ReportDepart\Models\ReportDepart;
use App\Containers\ReportDepartQuestion\Models\ReportDepartQuestion;
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
    protected $plan, $plan_depart, $company, $order, $report, $report_depart, $report_depart_question;

    public function setUp()
    {
        parent::setUp();

        $this->plan = factory(Plan::class)->create();
        $this->plan_depart = factory(PlanDepart::class)->create([
            'plan_id' => $this->plan->id,
        ]);
        factory(PlanDepartQuestion::class, 19)->create([
            'plan_depart_id' => $this->plan_depart->id,
        ]);
        $plan_depart_question = factory(PlanDepartQuestion::class)->create([
            'plan_depart_id' => $this->plan_depart->id,
        ]);
        $this->company = factory(Company::class)->create([
            'name' => "This is an Company"
        ]);
        $this->order = factory(Order::class)->create([
            'plan_id'    => $this->plan->id,
            'company_id' => $this->company->id,
        ]);
        $this->report = factory(Report::class)->create([
            'order_id' => $this->order->id,
        ]);

        $this->report_depart = factory(ReportDepart::class)->create([
            'report_id' => $this->report->id,
        ]);

        factory(ReportDepart::class, 3)->create([
            'report_id' => $this->report->id,
        ]);

        $this->report_depart_question = factory(ReportDepartQuestion::class)->create([
            'client_answer'     => $this->faker->name,
            'report_depart_id'  => $this->report_depart->id,
            'conclusion_status' => '合格',
        ]);

        factory(QuestionDetail::class, 5)->create([
            'question'                => 'question3',
            'plan_depart_question_id' => $plan_depart_question->id,
        ]);

        factory(ReportDepartQuestion::class, 2)->create([
            'client_answer'     => $this->faker->name,
            'report_depart_id'  => $this->report_depart->id,
            'conclusion_status' => '一般',
        ]);
        factory(ReportDepartQuestion::class, 3)->create([
            'client_answer'     => $this->faker->name,
            'report_depart_id'  => $this->report_depart->id,
            'conclusion_status' => '中等',
        ]);
        factory(ReportDepartQuestion::class, 4)->create([
            'client_answer'     => $this->faker->name,
            'report_depart_id'  => $this->report_depart->id,
            'conclusion_status' => '偏高',
        ]);
        factory(ReportDepartQuestion::class, 5)->create([
            'client_answer'     => $this->faker->name,
            'report_depart_id'  => $this->report_depart->id,
            'conclusion_status' => '严重',
        ]);
    }
}
