<?php

namespace App\Containers\Order\UI\API\Transformers\Mobile;

use App\Containers\Invitation\Models\Invitation;
use App\Containers\Order\Models\Order;
use App\Containers\Report\UI\API\Transformers\ReportTransformer;
use App\Ship\Parents\Transformers\Transformer;

class ClientOrderTransformer extends Transformer
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
     * @param Order $entity
     *
     * @return array
     */
    public function transform(Order $entity)
    {


        $response = [
            'object'   => 'Order',
            //客户名称+年份+诊断报告
            'name'     => $entity->reports()->latest()->first()->name,
            //report_id
            'id'       => $entity->reports()->latest()->first()->getHashedKey(),
            'status'   => $entity->status,
            'start_at' => $entity->start_at ? $entity->start_at->toDateTimeString() : null,
        ];

        return $response;
    }

}
