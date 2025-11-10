<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CommentRequest;
use App\Http\Requests\Task\SetStatusRequest;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskDeleteRequest;
use App\Http\Requests\Task\TaskListRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Services\TaskService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskListRequest $request)
    {
        return ApiResponse::success(TaskResource::collection($this->taskService->list($request)));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateRequest $request)
    {
        return ApiResponse::success(TaskResource::make($this->taskService->create($request)), [], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ApiResponse::success(TaskResource::make($this->taskService->get($id)));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request)
    {
        return ApiResponse::success($this->taskService->update($request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskDeleteRequest $request)
    {
        $this->taskService->delete($request);

        return ApiResponse::success([], [], 204);
    }

    /**
     * @param SetStatusRequest $request
     * @return JsonResponse
     */
    public function setStatus(SetStatusRequest $request): JsonResponse
    {
        $this->taskService->setStatus($request);

        return ApiResponse::success();
    }

    /**
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function addComment(CommentRequest $request): JsonResponse
    {
        $this->taskService->addComment($request);

        return ApiResponse::success();
    }
}
