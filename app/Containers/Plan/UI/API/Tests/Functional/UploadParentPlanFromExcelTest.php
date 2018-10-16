<?php
//
//namespace App\Containers\Plan\UI\API\Tests\Functional;
//
//use App\Containers\Plan\Tests\TestCase;
//use Illuminate\Http\UploadedFile;
//
///**
// * Class UpdatePlanTest.
// *
// * @author Mahmoud Zalt <mahmoud@zalt.me>
// */
//class UploadParentPlanFromExcelTest extends TestCase
//{
//
//  protected $endpoint = 'put@v1/upload_parent_plan_excel';
//
//  protected $access = [
//    'roles'       => '',
//    'permissions' => 'manage-parent_plans',
//  ];
//
//  public function testUploadParentPlanFromExcelTest_()
//  {
//    $this->getTestingUser([
//      'username' => 'username'
//    ]);
//
//    $data = [
//      'plan_excel' => UploadedFile::fake()->create('parent_plans.xlsx'),
//    ];
//
//    // send the HTTP request
//    $response = $this->makeCall($data);
//
//    // assert response status is correct
//    $response->assertStatus(200);
//
//    // assert returned user is the updated one
//    $this->assertResponseContainKeyValue([
//      'status' => true,
//      'msg'    => '导入成功',
//    ]);
//
//  }
//
//}
//
//
