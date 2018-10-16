<?php

namespace App\Containers\Invitation\Tasks;

use App\Containers\Invitation\Data\Repositories\InvitationRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindInvitationByIdTask extends Task
{

    private $repository;

    public function __construct(InvitationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
