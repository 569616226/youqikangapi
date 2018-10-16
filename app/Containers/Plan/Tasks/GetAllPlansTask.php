<?php

namespace App\Containers\Plan\Tasks;

use App\Containers\Plan\Data\Criterias\GeneralsCriteria;
use App\Containers\Plan\Data\Repositories\PlanRepository;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;

class GetAllPlansTask extends Task
{

    private $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($skipPagination = false)
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    public function ordered()
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
    }

    public function generals()
    {
        $this->repository->pushCriteria(new GeneralsCriteria());
    }

}
