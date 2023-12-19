<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(protected TaskRepository $repository)
    {
    }

    public function getList($requestData)
    {
        return $this->repository->getList($requestData);
    }

    public function store($requestData)
    {
        $task = $this->repository->store($requestData);
        return $task;
    }

    public function update($requestData, $task)
    {
        return $this->repository->update($requestData, $task);
    }

    public function delete($task)
    {
        return $this->repository->delete($task);
    }
}
