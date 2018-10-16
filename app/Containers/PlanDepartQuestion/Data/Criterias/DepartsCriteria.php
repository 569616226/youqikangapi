<?php

namespace App\Containers\PlanDepartQuestion\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ClientsCriteria.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class DepartsCriteria extends Criteria
{

    private $plan_depart_id;

    /**
     * DepartsCriteria constructor.
     * @param $plan_depart_id
     */
    public function __construct($plan_depart_id)
    {
        $this->plan_depart_id = $plan_depart_id;
    }


    /**
     * @param                                                   $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where('plan_depart_id', $this->plan_depart_id);
    }
}
