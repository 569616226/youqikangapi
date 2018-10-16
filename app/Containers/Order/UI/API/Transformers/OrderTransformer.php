<?php

namespace App\Containers\Order\UI\API\Transformers;

use App\Containers\Company\UI\API\Transformers\CompanyTransformer;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\UI\API\Transformers\PlanTransformer;
use App\Ship\Parents\Transformers\Transformer;

class OrderTransformer extends Transformer
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
        'company',
        'plan',
    ];

    /**
     * @param Order $entity
     *
     * @return array
     */
    public function transform(Order $entity)
    {

        $report_create_at = $entity->reports->isEmpty() ? '暂无报告' : $entity->reports()->latest()->first()->created_at->toDateTimeString();
        $response = [
            'object'           => 'Order',
            'id'               => $entity->getHashedKey(),
            'name'             => $entity->name,
            'status'           => $entity->status,
            'company_name'     => $entity->company->name,
            'plan_name'        => $entity->plan->name,
            'order_number'     => $entity->order_number,
            'report_create_at' => $report_create_at,
            'created_at'       => $entity->created_at->toDateTimeString(),
            'updated_at'       => $entity->updated_at->toDateTimeString(),
            'start_at'         => $entity->start_at ? $entity->start_at->toDateTimeString() : null,
            'deleted_at'       => $entity->deleted_at ? $entity->deleted_at->toDateTimeString() : null,

        ];

        $response = $this->ifAdmin([
            'real_id' => $entity->id,
        ], $response);

        return $response;
    }

    public function includePlan(Order $entity)
    {
        return $this->item($entity->plan, new PlanTransformer());
    }


    public function includeCompany(Order $entity)
    {
        return $this->item($entity->company, new CompanyTransformer());
    }

}
