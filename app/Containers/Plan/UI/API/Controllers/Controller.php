<?php

namespace App\Containers\Plan\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Models\Plan;
use App\Containers\Plan\UI\API\Requests\CreatePlanRequest;
use App\Containers\Plan\UI\API\Requests\DeletePlanRequest;
use App\Containers\Plan\UI\API\Requests\FindPlanByIdRequest;
use App\Containers\Plan\UI\API\Requests\GetAllPlansRequest;
use App\Containers\Plan\UI\API\Requests\UpdatePlanRequest;
use App\Containers\Plan\UI\API\Requests\UploadPlanFromExcelRequest;
use App\Containers\Plan\UI\API\Transformers\PlanTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\Plan\UI\API\Controllers
 */
class Controller extends ApiController
{
  /**
   * @param CreatePlanRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createPlan(CreatePlanRequest $request)
  {
    $plan = Apiato::call('Plan@CreatePlanAction', [$request]);

    if ($plan) {
      return success_simple_respone('方案新建成功');
    } else {
      return success_simple_respone();
    }
  }

  /**
   * @param FindPlanByIdRequest $request
   * @return array
   */
  public function findPlanById(FindPlanByIdRequest $request)
  {
    $plan = Apiato::call('Plan@FindPlanByIdAction', [$request]);

    return $this->transform($plan, PlanTransformer::class);
  }

  /**
   *
   * @return array
   */
  public function findParentPlan()
  {
    $plan = Apiato::call('Plan@FindParentPlanAction');

    return $this->transform($plan, PlanTransformer::class);
  }

  /**
   * @param GetAllPlansRequest $request
   * @return array
   */
  public function getAllPlans(GetAllPlansRequest $request)
  {
    $plans = Apiato::call('Plan@GetAllPlansAction', [$request]);

    return $this->transform($plans, PlanTransformer::class);
  }

  /**
   * @param UpdatePlanRequest $request
   * @return array
   */
  public function updatePlan(UpdatePlanRequest $request)
  {
    $plan = Apiato::call('Plan@UpdatePlanAction', [$request]);

    if ($plan instanceof Plan) {
      return success_simple_respone('方案更新成功');
    } else {
      return $plan;
    }

  }

  /**
   * @param DeletePlanRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function deletePlan(DeletePlanRequest $request)
  {
    return Apiato::call('Plan@DeletePlanAction', [$request]);

  }

  /**
   * @param UploadPlanFromExcelRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function uploadPlanFromExcel(UploadPlanFromExcelRequest $request)
  {
    $result = Apiato::call('Plan@UploadPlanFromExcelAction', [$request]);

    if ($result) {
      return success_simple_respone('导入成功');
    } else {
      return error_simple_respone();
    }
  }
}
