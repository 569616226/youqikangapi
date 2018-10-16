<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Admin\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\Models\QuestionDetail;

/**
 * Class DeletePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeletePlanDepartQuestionTest extends TestCase
{

  protected $endpoint = 'delete@v1/plan_depart_questions/{id}';

  protected $access = [
    'roles'       => '',
    'permissions' => 'manage-plans',
  ];

  public function testDeleteExistingPlanDepartQuetion_()
  {

    /*
     * 删除方案
     *
     * */
    $revisionHistory = $this->plan_depart_question->revisionHistory()->count();
    $question_detail_revisionHistory = $this->question_detail->revisionHistory()->count();

    // send the HTTP request
    $response = $this->injectId($this->plan_depart_question->id)->makeCall();

    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => '问题删除成功',
    ]);

    $deleted_plan_depart_question = PlanDepartQuestion::withTrashed()->find($this->plan_depart_question->id);
    $deleted_question_detail = QuestionDetail::withTrashed()->find($this->question_detail->id);

    $this->assertCount($revisionHistory + 1, $deleted_plan_depart_question->revisionHistory);
    $this->assertCount($question_detail_revisionHistory + 1, $deleted_question_detail->revisionHistory);
  }

  public function testDeleteExistingParentPlanPlanDepartQuetion_()
  {
    $user = $this->getTestingUser([
      'username' => 'admin'
    ]);

    /*
     * 删除方案
     *
     * */
    $revisionHistory = $this->plan_depart_question_3->revisionHistory()->count();

    // send the HTTP request
    $response = $this->injectId($this->plan_depart_question_3->id)->makeCall();

    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => '问题删除成功',
    ]);

    $deleted_plan_depart_question = PlanDepartQuestion::withTrashed()->find($this->plan_depart_question_3->id);

    $this->assertEquals($user->username, $deleted_plan_depart_question->plan_depart->plan->editer);
    $this->assertCount($revisionHistory + 1, $deleted_plan_depart_question->revisionHistory);

  }


  public function testDeleteExistingCompanyPlanDepartQuestion_()
  {

    /*
     * 删除方案
     *
     * 如果方案已经被使用,就不能删除和编辑
     * */

    $revisionHistory = $this->plan_depart_question_2->revisionHistory()->count();
    $question_detail_revisionHistory = $this->question_detail_2->revisionHistory()->count();

    // send the HTTP request
    $response = $this->injectId($this->plan_depart_question_2->id)->makeCall();

    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => false,
      'msg'    => '该方案的订单已经完成,不能编辑删除方案内容',
    ]);

    $deleted_plan_depart_question = PlanDepartQuestion::withTrashed()->find($this->plan_depart_question_2->id);
    $deleted_question_detail = QuestionDetail::withTrashed()->find($this->question_detail_2->id);

    $this->assertCount($revisionHistory, $deleted_plan_depart_question->revisionHistory);
    $this->assertCount($question_detail_revisionHistory, $deleted_question_detail->revisionHistory);
  }

}
