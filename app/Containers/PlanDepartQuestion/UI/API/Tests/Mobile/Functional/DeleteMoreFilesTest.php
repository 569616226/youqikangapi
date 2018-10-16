<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class FindReportTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteMoreFilesTest extends TestCase
{

    protected $endpoint = 'post@v1/plan_depart_questions/{id}/del_question_more_files';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testDeleteMoreFiles_()
    {
        $this->getTestingUser([
            'username' => '系统'
        ]);

        $data = [
            'image_url_index' => 0,
        ];

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();
        $more_files = count($this->plan_depart_question->more_files);

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert the returned message is correct
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '删除成功',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);
        $update_more_files = count($update_plan_depart_question->more_files);

        $this->assertCount($revisionHistory + 1, $update_plan_depart_question->revisionHistory);
        $this->assertEquals($more_files, $update_more_files + 1);

    }

}
