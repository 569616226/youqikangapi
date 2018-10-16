<?php

namespace App\Containers\QuestionDetail\Tasks;

use App\Containers\QuestionDetail\Data\Repositories\QuestionDetailRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindQuestionDetailByIdTask extends Task
{

    private $repository;

    public function __construct(QuestionDetailRepository $repository)
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
