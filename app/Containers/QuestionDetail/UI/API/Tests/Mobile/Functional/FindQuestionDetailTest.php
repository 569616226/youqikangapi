<?php

namespace App\Containers\QuestionDetail\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;

/**
 * Class FindPlanTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindQuestionDetailTest extends TestCase
{

    protected $endpoint = 'get@v1/question_details/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testFindQuestionDetailById_()
    {

        // send the HTTP request
        $response = $this->injectId($this->question_detail->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->question_detail->question, $responseContent->data->question);
        $this->assertEquals($this->question_detail->answer, $responseContent->data->answer);

    }

}
