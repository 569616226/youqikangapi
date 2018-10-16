<?php

namespace App\Containers\Invitation\Tasks;

use App\Containers\Invitation\Data\Repositories\InvitationRepository;
use App\Ship\Parents\Tasks\Task;

class GetAllInvitationsTask extends Task
{

    private $repository;

    public function __construct(InvitationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->paginate();
    }
}
