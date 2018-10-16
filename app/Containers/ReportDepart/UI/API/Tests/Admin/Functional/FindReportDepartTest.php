<?php

namespace App\Containers\ReportDepart\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Tests\TestCase;

/**
 * Class FindReportTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindReportDepartTest extends TestCase
{

    protected $endpoint = 'get@v1/report_departs/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testFindReportDepartById_()
    {
        $this->getTestingUser([
            'username' => '系统'
        ]);

        // send the HTTP request
        $response = $this->injectId($this->report_depart->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->report_depart->name, $responseContent->data->name);
        $this->assertEquals($this->report_depart->icon, $responseContent->data->icon);
        $this->assertEquals(1, $responseContent->data->nomarl_counts);
        $this->assertEquals(2, $responseContent->data->general_counts);
        $this->assertEquals(3, $responseContent->data->middle_counts);
        $this->assertEquals(4, $responseContent->data->hight_counts);
        $this->assertEquals(5, $responseContent->data->serious_counts);
        $this->assertEquals(15, $responseContent->data->counts);
        $this->assertNotNull($responseContent->data->type);
        $this->assertNotNull($responseContent->data->general_questions);
        $this->assertNotNull($responseContent->data->middle_questions);
        $this->assertNotNull($responseContent->data->hight_questions);
        $this->assertNotNull($responseContent->data->serious_questions);
        $this->assertNotNull($responseContent->data->nomarl_questions);
        $this->assertEquals($this->report_depart->created_at->toDateTimeString(), $responseContent->data->created_at);

    }

}
