<?php

namespace App\Containers\PlanDepart\Tasks;

use App\Containers\PlanDepart\Data\Criterias\PlansCriteria;
use App\Containers\PlanDepart\Data\Repositories\PlanDepartRepository;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;

class GetAllPlanDepartsTask extends Task
{

    private $repository;

    public function __construct(PlanDepartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($skipPagination = false, $plan_id)
    {
        $this->repository->pushCriteria(new PlansCriteria($plan_id));

        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function ordered()
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
    }
}
