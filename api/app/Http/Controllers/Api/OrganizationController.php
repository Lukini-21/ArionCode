<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationListRequest;
use App\Http\Resources\Organization\OrganizationResource;
use App\Services\OrganizationService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct(private readonly OrganizationService $organizationService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrganizationListRequest $request): JsonResponse
    {
        return ApiResponse::success(OrganizationResource::collection($this->organizationService->list($request)));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ApiResponse::success(OrganizationResource::make($this->organizationService->get($id)));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
