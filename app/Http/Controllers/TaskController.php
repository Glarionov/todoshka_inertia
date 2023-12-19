<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\GetListTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    {
    }

    /**
     * @return Response
     */
    public function mainPage(): Response
    {
        $tasks = $this->service->getList();
        return Inertia::render('Task/TaskRoom', ['tasksProp' => $tasks]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(GetListTaskRequest $request): AnonymousResourceCollection
    {
        $data = $this->service->getList($request->validated());
        return TaskResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $data = $this->service->store($request->validated());
        return $this->successBackRedirect($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $data = $this->service->update($request->validated(), $task);
        return $this->successBackRedirect(TaskResource::make($data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->service->delete($task);
        return $this->successBackRedirect();
    }
}
