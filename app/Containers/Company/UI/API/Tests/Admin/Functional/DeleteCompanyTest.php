<?php

namespace App\Containers\Company\UI\API\Tests\Admin\Functional;

use App\Containers\Company\Models\Company;
use App\Containers\Company\Tests\TestCase;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\Models\Plan;

/**
 * Class DeleteCompanyTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteCompanyTest extends TestCase
{

    protected $endpoint = 'delete@v1/companies/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-companies',
    ];

    public function testDeleteExistingCompany_()
    {

        /*客户删除，客户联系人是否要删除*/

        $this->getTestingUser();

        $company = factory(Company::class)->create();
        $plan = factory(Plan::class)->create();
        factory(Order::class)->create([
            'status'     => '未开始',
            'plan_id'    => $plan->id,
            'company_id' => $company->id,
        ]);

        $revisionHistory = $company->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($company->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '客户删除成功',
        ]);

        $deleted_company = Company::withTrashed()->find($company->id);

        $this->assertCount($revisionHistory + 1, $deleted_company->revisionHistory);
    }

    public function testDeleteExistingCompanyWithNoOrder_()
    {

        /*客户删除，客户联系人是否要删除*/

        $this->getTestingUser();

        $company = factory(Company::class)->create();

        $revisionHistory = $company->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($company->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '客户删除成功',
        ]);

        $deleted_company = Company::withTrashed()->find($company->id);

        $this->assertCount($revisionHistory + 1, $deleted_company->revisionHistory);
    }


    public function testDeleteExistingCompanyError_()
    {

        /*客户删除，客户联系人是否要删除*/

        $this->getTestingUser();

        $plan = factory(Plan::class)->create();
        factory(Order::class)->create([
            'status'     => '已完成',
            'plan_id'    => $plan->id,
            'company_id' => $this->company->id,
        ]);

        // send the HTTP request
        $response = $this->injectId($this->company->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '不能删除有订单项目在进行的客户',
        ]);


    }

}
