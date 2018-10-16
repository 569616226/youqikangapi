<?php

namespace App\Containers\PlanDepart\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepart\UI\API\Requests\CreatePlanDepartRequest;
use App\Containers\PlanDepart\UI\API\Requests\DeletePlanDepartRequest;
use App\Containers\PlanDepart\UI\API\Requests\FindPlanDepartByIdRequest;
use App\Containers\PlanDepart\UI\API\Requests\GetAllPlanDepartsRequest;
use App\Containers\PlanDepart\UI\API\Requests\UpdatePlanDepartRequest;
use App\Containers\PlanDepart\UI\API\Transformers\PlanDepartTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\PlanDepart\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreatePlanDepartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPlanDepart(CreatePlanDepartRequest $request)
    {
        $plan_depart = Apiato::call('PlanDepart@CreatePlanDepartAction', [$request]);

        if ($plan_depart instanceof PlanDepart) {
            return success_simple_respone($plan_depart->name . ' 部门新建成功');
        } else {
            return $plan_depart;
        }
    }

    /**
     * @param FindPlanDepartByIdRequest $request
     * @return array
     */
    public function findPlanDepartById(FindPlanDepartByIdRequest $request)
    {
        $plandepart = Apiato::call('PlanDepart@FindPlanDepartByIdAction', [$request]);

        return $this->transform($plandepart, PlanDepartTransformer::class);
    }

    /**
     * @param GetAllPlanDepartsRequest $request
     * @return array
     */
    public function getAllPlanDeparts(GetAllPlanDepartsRequest $request)
    {
        $plandeparts = Apiato::call('PlanDepart@GetAllPlanDepartsAction', [$request]);

        return $this->transform($plandeparts, PlanDepartTransformer::class);
    }

    /**
     * @param UpdatePlanDepartRequest $request
     * @return array
     */
    public function updatePlanDepart(UpdatePlanDepartRequest $request)
    {
        $plan_depart = Apiato::call('PlanDepart@UpdatePlanDepartAction', [$request]);

        if ($plan_depart) {
            return success_simple_respone('部门更新成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param DeletePlanDepartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePlanDepart(DeletePlanDepartRequest $request)
    {
        return Apiato::call('PlanDepart@DeletePlanDepartAction', [$request]);

    }
}
