<?php

namespace App\Containers\Company\UI\API\Transformers\Mobile;

use App\Containers\Company\Models\Company;
use App\Containers\Order\UI\API\Transformers\Mobile\MobileOrderTransformer;
use App\Ship\Parents\Transformers\Transformer;

class MobileCompanyTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
        'orders'
    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    /**
     * @param Company $entity
     *
     * @return array
     */
    public function transform(Company $entity)
    {
        $response = [
            'object'     => 'Company',
            'id'         => $entity->getHashedKey(),
            'name'       => $entity->name,
            'logo'       => $entity->logo,
            'created_at' => $entity->created_at->toDateTimeString(),
        ];

        return $response;
    }

    public function includeOrders(Company $entity)
    {

        $orders = $entity->orders()->whereIn('status', [
            '进行中',
            '已完成'
        ])->latest()->get();

        return $this->collection($orders, new MobileOrderTransformer());

    }

}
