<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class GetAllPlansTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllMobilePlanDepartQuestionsTest extends TestCase
{

    protected $endpoint = 'get@v1/plan_depart/{id}/mobile/questions';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testGetAllMobilePlanDeaprtQuestionsIsAudit_()
    {
        $this->getTestingUser(['is_audit' => true]);

        factory(PlanDepartQuestion::class, 3)->create([
            'status'         => '未开始',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);
        factory(PlanDepartQuestion::class, 4)->create([
            'status'         => '调查中',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);
        factory(PlanDepartQuestion::class, 5)->create([
            'status'         => '审核中',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);
        factory(PlanDepartQuestion::class, 6)->create([
            'status'         => '审核成功',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);

        factory(PlanDepartQuestion::class, 7)->create([
            'status'         => '已驳回',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->injectId($this->plan_depart->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(5, $responseContent->auditing->data);
        $this->assertCount(6, $responseContent->success_audit->data);
        $this->assertCount(7, $responseContent->not_audit->data);
        $this->assertEquals(5, $responseContent->auditing_count);
        $this->assertEquals(6, $responseContent->success_audit_count);
        $this->assertEquals(7, $responseContent->not_audit_count);
        $this->assertEquals(27, $responseContent->all_count);
        $this->assertFalse($responseContent->is_finish);
    }

    public function testGetAllMobilePlanDeaprtQuestions_()
    {
        $this->getTestingUser(['is_audit' => false]);

        factory(PlanDepartQuestion::class, 3)->create([
            'status'         => '未开始',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);
        factory(PlanDepartQuestion::class, 4)->create([
            'status'         => '调查中',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);
        factory(PlanDepartQuestion::class, 5)->create([
            'status'         => '审核中',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);
        factory(PlanDepartQuestion::class, 6)->create([
            'status'         => '审核成功',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);

        factory(PlanDepartQuestion::class, 7)->create([
            'status'         => '已驳回',
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->injectId($this->plan_depart->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(14, $responseContent->no_complate->data);
        $this->assertCount(6, $responseContent->success_audit->data);
        $this->assertCount(7, $responseContent->not_audit->data);
        $this->assertEquals(14, $responseContent->no_complate_count);
        $this->assertEquals(6, $responseContent->success_audit_count);
        $this->assertEquals(7, $responseContent->not_audit_count);
        $this->assertEquals(27, $responseContent->all_count);
        $this->assertFalse($responseContent->is_finish);
    }

}
