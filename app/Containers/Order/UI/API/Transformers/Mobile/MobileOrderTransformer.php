<?php

namespace App\Containers\Order\UI\API\Transformers\Mobile;

use App\Containers\Company\UI\API\Transformers\CompanyTransformer;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\UI\API\Transformers\Mobile\MobilePlanTransformer;
use App\Containers\Plan\UI\API\Transformers\PlanTransformer;
use App\Containers\PlanDepart\UI\API\Transformers\Mobile\MobilePlanDepartTransformer;
use App\Containers\Report\UI\API\Transformers\ReportTransformer;
use App\Ship\Parents\Transformers\Transformer;

class MobileOrderTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
        'plan'
    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    /**
     * @param Order $entity
     *
     * @return array
     */
    public function transform(Order $entity)
    {

        $response = [
            'object'    => 'Order',
            'id'        => $entity->getHashedKey(),
            'name'      => $entity->reports->isEmpty() ? $entity->name : $entity->reports()->latest()->first()->name,
            'report_id' => $entity->reports->isEmpty() ? null : $entity->reports()->latest()->first()->getHashedKey(),
            'status'    => $entity->status,
            'start_at'  => $entity->start_at ? $entity->start_at->toDateTimeString() : null,
        ];

        return $response;
    }

    public function includePlan(Order $entity)
    {
        return $this->item($entity->plan, new MobilePlanTransformer());
    }

    public function includeCompany(Order $entity)
    {
        return $this->item($entity->company, new CompanyTransformer());
    }

}
