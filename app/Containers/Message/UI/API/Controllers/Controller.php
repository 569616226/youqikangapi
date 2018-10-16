<?php

namespace App\Containers\Message\UI\API\Controllers;

use App\Containers\Message\UI\API\Requests\CreateMessageRequest;
use App\Containers\Message\UI\API\Requests\DeleteMessageRequest;
use App\Containers\Message\UI\API\Requests\GetAllMessagesRequest;
use App\Containers\Message\UI\API\Requests\FindMessageByIdRequest;
use App\Containers\Message\UI\API\Requests\UpdateMessageRequest;
use App\Containers\Message\UI\API\Transformers\MessageTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Apiato\Core\Foundation\Facades\Apiato;

/**
 * Class Controller
 *
 * @package App\Containers\Message\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreateMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMessage(CreateMessageRequest $request)
    {
        $message = Apiato::call('Message@CreateMessageAction', [$request]);

        return $this->created($this->transform($message, MessageTransformer::class));
    }

    /**
     * @param FindMessageByIdRequest $request
     * @return array
     */
    public function findMessageById(FindMessageByIdRequest $request)
    {
        $message = Apiato::call('Message@FindMessageByIdAction', [$request]);

        return $this->transform($message, MessageTransformer::class);
    }

    /**
     * @param GetAllMessagesRequest $request
     * @return array
     */
    public function getAllMessages(GetAllMessagesRequest $request)
    {
        $messages = Apiato::call('Message@GetAllMessagesAction', [$request]);

        return $this->transform($messages, MessageTransformer::class);
    }

    /**
     * @param UpdateMessageRequest $request
     * @return array
     */
    public function updateMessage(UpdateMessageRequest $request)
    {
        $message = Apiato::call('Message@UpdateMessageAction', [$request]);

        return $this->transform($message, MessageTransformer::class);
    }

    /**
     * @param DeleteMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMessage(DeleteMessageRequest $request)
    {
        Apiato::call('Message@DeleteMessageAction', [$request]);

        return $this->noContent();
    }
}
