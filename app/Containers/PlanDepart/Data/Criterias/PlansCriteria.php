<?php

namespace App\Containers\PlanDepart\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ClientsCriteria.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class PlansCriteria extends Criteria
{

    private $plan_id;

    /**
     * DepartsCriteria constructor.
     * @param $plan_id
     */
    public function __construct($plan_id)
    {
        $this->plan_id = $plan_id;
    }


    /**
     * @param                                                   $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where('plan_id', $this->plan_id);
    }
}
