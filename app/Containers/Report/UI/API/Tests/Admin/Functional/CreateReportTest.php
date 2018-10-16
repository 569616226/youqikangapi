<?php

namespace App\Containers\Report\UI\API\Tests\Admin\Functional;

use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\Report\Models\Report;
use App\Containers\Order\Tests\TestCase;
use App\Containers\ReportDepartQuestion\Models\ReportDepartQuestion;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateReportTest extends TestCase
{

    protected $endpoint = 'post@v1/orders/{id}/create_reports';

    protected $auth = true;

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testCreateReport_()
    {
        $user = $this->getTestingUser([
            'username'        => 'admin',
            'open_id'         => 'ogAws1FTFygg1D0IYS7HDnXocErc',
            'is_client'       => true,
            'is_client_admin' => true,
        ]);

        $user->companies()->attach($this->order->company->id);

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => 'This is an Company' . now()->year . '年诊断报告生成成功',
        ]);

        $reports = Report::whereName('This is an Company' . now()->year . '年诊断报告')->get();

        /*方案问题数量*/
        $plan_depart_ids = $this->order->plan->plan_departs->pluck('id')->toArray();
        $plan_depart_questions = PlanDepartQuestion::whereIn('plan_depart_id', $plan_depart_ids)->get()->count();

        /*报告问题数量*/
        $report_depart_ids = $reports->first()->report_departs->pluck('id')->toArray();
        $report_depart_questions = ReportDepartQuestion::whereIn('report_depart_id', $report_depart_ids)->get()->count();

        $this->assertCount(1, $reports);
        $this->assertCount($this->order->plan->plan_departs->count(), $reports->first()->report_departs);
        $this->assertEquals($plan_depart_questions, $report_depart_questions);
        $this->assertCount(1, $reports->first()->revisionHistory);

    }

    public function testCreateReportNoClientAdmin_()
    {
        $user = $this->getTestingUser([
            'username'        => 'admin',
            'is_client'       => true,
            'is_client_admin' => false,
        ]);

        $user->companies()->attach($this->order->company->id);

        // send the HTTP request
        $response = $this->injectId($this->order->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);
        $reports = Report::whereName('This is an Company' . now()->year . '年诊断报告')->get();

        /*方案问题数量*/
        $plan_depart_ids = $this->order->plan->plan_departs->pluck('id')->toArray();
        $plan_depart_questions = PlanDepartQuestion::whereIn('plan_depart_id', $plan_depart_ids)->get()->count();

        /*报告问题数量*/
        $report_depart_ids = $reports->first()->report_departs->pluck('id')->toArray();
        $report_depart_questions = ReportDepartQuestion::whereIn('report_depart_id', $report_depart_ids)->get()->count();

        $this->assertCount(1, $reports);
        $this->assertCount($this->order->plan->plan_departs->count(), $reports->first()->report_departs);
        $this->assertEquals($plan_depart_questions, $report_depart_questions);
        $this->assertCount(1, $reports->first()->revisionHistory);

    }

}
