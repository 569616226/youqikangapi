<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Admin\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class GetAllPlansTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllPlanDepartQuestionsTest extends TestCase
{

    protected $endpoint = 'get@v1/plan_depart/{id}/questions';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testGetAllPlanDeaprtQuestions_()
    {
        $this->getTestingUser();


        $plan_depart_question = factory(PlanDepartQuestion::class)->create([
            'plan_depart_id' => $this->plan_depart->id,
            'created_at'     => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->injectId($this->plan_depart->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(3, $responseContent->data);

        $this->assertEquals($plan_depart_question->question, $responseContent->data[0]->name);
    }

}
