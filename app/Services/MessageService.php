<?php

namespace App\Services;

use App\Http\Resources\MessageResource;
use App\Repositories\MessageRepository;
use App\Events\MessageSent;

class MessageService
{
    public function __construct(protected MessageRepository $repository)
    {
    }

    public function getList($requestData)
    {
        return $this->repository->getList($requestData);
    }

    public function store($requestData)
    {
        $message = $this->repository->store($requestData);
        broadcast(new MessageSent($message));

        return $message;
    }
}
