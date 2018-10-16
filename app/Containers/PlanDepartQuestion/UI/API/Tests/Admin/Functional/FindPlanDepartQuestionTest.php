<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Admin\Functional;

use App\Containers\Plan\Tests\TestCase;

/**
 * Class FindPlanTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindPlanDepartQuestionTest extends TestCase
{

    protected $endpoint = 'get@v1/plan_depart_questions/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testFindPlanDepartQuestionById_()
    {


        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall();
        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->plan_depart_question->question, $responseContent->data->name);
        $this->assertEquals($this->plan_depart_question->answers, $responseContent->data->answers);

    }

}
