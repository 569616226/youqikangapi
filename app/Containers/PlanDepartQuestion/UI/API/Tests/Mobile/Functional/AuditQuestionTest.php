<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class AuditQuestionTest extends TestCase
{

    protected $endpoint = 'patch@v1/plan_depart_questions/{id}/audit_question';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testAuditQuestionSuccess_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin',
            'is_audit' => true,
        ]);

        $data = [
            'status'     => '审核成功',
            'audit_text' => '审核成功',
        ];

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '审核成功',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);


        $this->assertEquals($user->username, $update_plan_depart_question->auditer);
        $this->assertEquals($data['status'], $update_plan_depart_question->status);
        $this->assertEquals($data['audit_text'], $update_plan_depart_question->audit_text);
        $this->assertNotNull($update_plan_depart_question->audit_at);
        $this->assertCount($revisionHistory + 3, $update_plan_depart_question->revisionHistory);
    }


    public function testAuditQuestionError_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin',
            'is_audit' => true,
        ]);

        $data = [
            'status'     => '已驳回',
            'audit_text' => '已驳回',
        ];

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '已驳回',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);

        $this->assertEquals($user->username, $update_plan_depart_question->auditer);
        $this->assertEquals($data['status'], $update_plan_depart_question->status);
        $this->assertEquals($data['audit_text'], $update_plan_depart_question->audit_text);
        $this->assertNotNull($update_plan_depart_question->audit_at);
        $this->assertCount($revisionHistory + 3, $update_plan_depart_question->revisionHistory);
    }

    public function testAuditQuestionWithNotAudit_()
    {

        $this->getTestingUser([
            'username' => 'admin',
            'is_audit' => false,
        ]);

        $data = [
            'status'     => '已驳回',
            'audit_text' => '已驳回',
        ];

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

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


