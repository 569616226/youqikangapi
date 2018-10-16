<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;

/**
 * Class FindPlanTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindMobilePlanDepartQuestionTest extends TestCase
{

    protected $endpoint = 'get@v1/plan_depart_questions/{id}/mobile';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testFindMobilePlanDepartQuestionById_()
    {

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->plan_depart_question->question, $responseContent->data->name);
        $this->assertEquals($this->plan_depart_question->status, $responseContent->data->status);
        $this->assertEquals($this->plan_depart_question->client_answer, $responseContent->data->client_answer);
        $this->assertEquals($this->plan_depart_question->more_files, $responseContent->data->more_files);
        $this->assertEquals($this->plan_depart_question->confirm_text, $responseContent->data->confirm_text);
        $this->assertEquals($this->plan_depart_question->confirm_at, $responseContent->data->confirm_at);
        $this->assertEquals($this->plan_depart_question->conclusion_at, $responseContent->data->conclusion_at);
        $this->assertEquals($this->plan_depart_question->conclusion, $responseContent->data->conclusion);
        $this->assertEquals($this->plan_depart_question->conclusion_editer, $responseContent->data->conclusion_editer);
        $this->assertEquals($this->plan_depart_question->confirm_editer, $responseContent->data->confirm_editer);
        $this->assertEquals($this->plan_depart_question->client_answer_editer, $responseContent->data->client_answer_editer);
        $this->assertEquals($this->plan_depart_question->auditer, $responseContent->data->auditer);
        $this->assertNotNull($responseContent->data->question_details);

    }

}
