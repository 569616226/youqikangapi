<?php

namespace App\Containers\Invitation\Tasks;

use App\Containers\Invitation\Data\Repositories\InvitationRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateInvitationTask extends Task
{

  private $repository;

  public function __construct(InvitationRepository $repository)
  {
    $this->repository = $repository;
  }

  public function run(array $data)
  {
    try {

      \DB::beginTransaction();

      $invitation = $this->repository->create($data);

      if ($invitation) {

        $invitation->users()->attach(\Auth::user()->id, ['is_client' => false]);

        \DB::commit();
        return $invitation;

      } else {

        \DB::rollback();
        return $invitation;
      }


    } catch (Exception $exception) {

      \DB::rollback();
      throw new CreateResourceFailedException();

    }
  }
}
