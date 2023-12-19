<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    protected $itemsPerPage = 30;

    /**
     * Gel list of the tasks
     *
     * @param $requestData
     * @return mixed
     */
    public function getList($requestData)
    {
        return Task::query()->when($requestData['task_id'] ?? null,
            function (Builder $query, string $taskId): void {
                $query->where('id', '<', $taskId);
        })->take($this->itemsPerPage)->orderBy('id', 'desc')->get()->keyBy('id');
    }

    /**
     * @param $requestData
     * @return Task
     */
    public function store($requestData)
    {
        $task = new Task();
        $task->text = $requestData['text'];
        $task->user_id = Auth::id();
        $task->save();
        return $task;
    }

    /**
     * @param $requestData
     * @param $task
     * @return mixed
     */
    public function update($requestData, $task)
    {
        $task->fill($requestData);
        $task->save();
        return $task;
    }

    /**
     * @param $task
     * @return bool
     */
    public function delete($task)
    {
        $task->delete();
        return true;
    }
}
