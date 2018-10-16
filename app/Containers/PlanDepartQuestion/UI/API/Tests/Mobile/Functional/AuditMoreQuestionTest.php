<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class AuditMoreQuestionTest extends TestCase
{

    protected $endpoint = 'patch@v1/plan_depart_questions/audit_more_question';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testAuditMoreQuestionsSuccess_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin',
            'is_audit' => true,
        ]);

        $data = [
            'question_ids' => [$this->plan_depart_question->getHashedKey()],
            'status'       => '审核成功',
        ];

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '操作成功',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);


        $this->assertEquals($user->username, $update_plan_depart_question->auditer);
        $this->assertEquals($data['status'], $update_plan_depart_question->status);
        $this->assertNotNull($update_plan_depart_question->audit_at);
        $this->assertCount($revisionHistory + 2, $update_plan_depart_question->revisionHistory);
    }

    public function testAuditMoreQuestionsError_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin',
            'is_audit' => true,
        ]);

        $data = [
            'status'       => '已驳回',
            'question_ids' => [$this->plan_depart_question->getHashedKey()],
        ];

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '操作成功',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);

        $this->assertEquals($user->username, $update_plan_depart_question->auditer);
        $this->assertEquals($data['status'], $update_plan_depart_question->status);
        $this->assertNotNull($update_plan_depart_question->audit_at);
        $this->assertCount($revisionHistory + 2, $update_plan_depart_question->revisionHistory);
    }

    public function testAuditMoreQuestionsWithNotAudit_()
    {

        $this->getTestingUser([
            'username' => 'admin',
            'is_audit' => false,
        ]);

        $data = [
            'status'       => '已驳回',
            'question_ids' => [$this->plan_depart_question->getHashedKey()],
        ];

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '负责人才能审核',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);
        $this->assertCount($revisionHistory, $update_plan_depart_question->revisionHistory);
    }

}


