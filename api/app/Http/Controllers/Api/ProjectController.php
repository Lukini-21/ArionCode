<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\AssignMembersRequest;
use App\Http\Requests\Project\ProjectCreateRequest;
use App\Http\Requests\Project\ProjectDeleteRequest;
use App\Http\Requests\Project\ProjectListRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Http\Requests\Project\SetStatusRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Services\ProjectService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $projectService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProjectListRequest $request): JsonResponse
    {
       return ApiResponse::success(ProjectResource::collection($this->projectService->list($request)));
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
    public function store(ProjectCreateRequest $request)
    {
        return ApiResponse::success($this->projectService->create($request), [], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ApiResponse::success(ProjectResource::make($this->projectService->get($id)));
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
    public function update(ProjectUpdateRequest $request)
    {
        return ApiResponse::success($this->projectService->update($request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectDeleteRequest $request): JsonResponse
    {
        $this->projectService->delete($request);

        return ApiResponse::success([], [], 204);
    }

    /**
     * @param SetStatusRequest $request
     * @return JsonResponse
     */
    public function setStatus(SetStatusRequest $request): JsonResponse
    {
        $this->projectService->setStatus($request);

        return ApiResponse::success();
    }

    public function assignMembers(AssignMembersRequest $request)
    {
        $this->projectService->assignMembers($request);

        return ApiResponse::success();
    }
}
