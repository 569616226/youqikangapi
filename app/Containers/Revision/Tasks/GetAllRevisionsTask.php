<?php

namespace App\Containers\Revision\Tasks;

use App\Containers\Revision\Data\Repositories\RevisionRepository;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;

class GetAllRevisionsTask extends Task
{

    private $repository;

    public function __construct(RevisionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($month = 3)
    {

        $revisions = $this->repository->all();

        $revision_filter = $revisions->filter(function ($item) use ($month) {
            return $item->created_at->diffInMonths(now()) <= $month;
        });

        return $revision_filter;

    }

    public function ordered()
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
    }

}
