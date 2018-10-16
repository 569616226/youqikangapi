<?php

namespace App\Containers\PlanDepart\UI\API\Transformers\Mobile;

use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\UI\API\Transformers\PlanDepartQuestionTransformer;
use App\Ship\Parents\Transformers\Transformer;

class MobilePlanDepartTransformer extends Transformer
{
  /**
   * @var  array
   */
  protected $defaultIncludes = [
  ];

  /**
   * @var  array
   */
  protected $availableIncludes = [

  ];

  /**
   * @param PlanDepart $entity
   *
   * @return array
   */
  public function transform(PlanDepart $entity)
  {
    /*
     * 调查过程-现场确认-最终结论都填写完成 所有问题完成
     *
     * 部门完成
     * */

    $questions = $entity->plan_depart_questions;

    $auditings = $questions->filter(function ($item) {
      return $item->status == '审核中';
    })->count();

    $complates = $questions->filter(function ($item) {
      return $item->status == '审核成功';
    })->count();

    $errors = $questions->filter(function ($item) {
      return $item->status == '已驳回';
    })->count();

    $response = [
      'object'     => 'PlanDepart',
      'id'         => $entity->getHashedKey(),
      'name'       => $entity->name,
      'icon'       => $entity->icon,
      'errors'  => $errors,
      'auditings'  => $auditings,
      'complates'  => $complates,
      'all_counts' => $questions->count(),
      'is_finish'  => $questions->count() == $complates,
    ];

    return $response;
  }

}
