<?php

namespace App\Containers\Plan\UI\API\Tests\Functional;


use App\Containers\Order\Models\Order;
use App\Containers\Plan\Models\Plan;
use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\Models\QuestionDetail;

/**
 * Class DeletePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeletePlanTest extends TestCase
{

    protected $endpoint = 'delete@v1/plans/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testDeleteExistingPlan_()
    {

        /*
         * 删除方案
         *
         * 如果方案已经被使用,就不能删除和编辑
         * */

        $revisionHistory = $this->plan->revisionHistory()->count();
        $plan_depart_revisionHistory = $this->plan_depart->revisionHistory()->count();
        $plan_depart_question_revisionHistory = $this->plan_depart_question->revisionHistory()->count();
        $question_detail_revisionHistory = $this->question_detail->revisionHistory()->count();

        factory(Order::class)->create([
            'status'     => '未开始',
            'company_id' => $this->company->id,
            'plan_id'    => $this->plan->id,
        ]);

        // send the HTTP request
        $response = $this->injectId($this->plan->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $this->plan->name . ' 方案删除成功',
        ]);

        $deleted_plan = Plan::withTrashed()->find($this->plan->id);
        $deleted_plan_depart = PlanDepart::withTrashed()->find($this->plan_depart->id);
        $deleted_plan_depart_question = PlanDepartQuestion::withTrashed()->find($this->plan_depart_question->id);
        $deleted_question_detail = QuestionDetail::withTrashed()->find($this->question_detail->id);

        $this->assertCount($revisionHistory + 1, $deleted_plan->revisionHistory);
        $this->assertCount($plan_depart_revisionHistory + 1, $deleted_plan_depart->revisionHistory);
        $this->assertCount($plan_depart_question_revisionHistory + 1, $deleted_plan_depart_question->revisionHistory);
        $this->assertCount($question_detail_revisionHistory + 1, $deleted_question_detail->revisionHistory);
    }

    public function testDeleteExistingPlanWithNoOrder_()
    {

        /*
         * 删除方案
         *
         * 如果方案已经被使用,就不能删除和编辑
         * */

        $revisionHistory = $this->plan->revisionHistory()->count();
        $plan_depart_revisionHistory = $this->plan_depart->revisionHistory()->count();
        $plan_depart_question_revisionHistory = $this->plan_depart_question->revisionHistory()->count();
        $question_detail_revisionHistory = $this->question_detail->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($this->plan->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $this->plan->name . ' 方案删除成功',
        ]);

        $deleted_plan = Plan::withTrashed()->find($this->plan->id);
        $deleted_plan_depart = PlanDepart::withTrashed()->find($this->plan_depart->id);
        $deleted_plan_depart_question = PlanDepartQuestion::withTrashed()->find($this->plan_depart_question->id);
        $deleted_question_detail = QuestionDetail::withTrashed()->find($this->question_detail->id);

        $this->assertCount($revisionHistory + 1, $deleted_plan->revisionHistory);
        $this->assertCount($plan_depart_revisionHistory + 1, $deleted_plan_depart->revisionHistory);
        $this->assertCount($plan_depart_question_revisionHistory + 1, $deleted_plan_depart_question->revisionHistory);
        $this->assertCount($question_detail_revisionHistory + 1, $deleted_question_detail->revisionHistory);
    }


    public function testDeleteExistingCompanyPlan_()
    {

        /*
         * 删除方案
         *
         * 如果方案已经被使用,就不能删除和编辑
         * */
        $revisionHistory = $this->plan_2->revisionHistory()->count();
        $plan_depart_revisionHistory = $this->plan_depart_2->revisionHistory()->count();
        $plan_depart_question_revisionHistory = $this->plan_depart_question_2->revisionHistory()->count();
        $question_detail_revisionHistory = $this->question_detail_2->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($this->plan_2->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '该方案的订单已经完成,不能编辑删除方案内容',
        ]);

        $deleted_plan = Plan::withTrashed()->find($this->plan_2->id);
        $deleted_plan_depart = PlanDepart::withTrashed()->find($this->plan_depart_2->id);
        $deleted_plan_depart_question = PlanDepartQuestion::withTrashed()->find($this->plan_depart_question_2->id);
        $deleted_question_detail = QuestionDetail::withTrashed()->find($this->question_detail_2->id);

        $this->assertCount($revisionHistory, $deleted_plan->revisionHistory);
        $this->assertCount($plan_depart_revisionHistory, $deleted_plan_depart->revisionHistory);
        $this->assertCount($plan_depart_question_revisionHistory, $deleted_plan_depart_question->revisionHistory);
        $this->assertCount($question_detail_revisionHistory, $deleted_question_detail->revisionHistory);
    }

}
