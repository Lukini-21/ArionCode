<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

/**
 *
 */
class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ApiResponse::success($this->notificationService->list($request));
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
        return ApiResponse::success($this->notificationService->get($id));
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
        $this->notificationService->delete($id);

        return ApiResponse::success([], [], 204);
    }

    /**
     * Set as read
     */
    public function setAsRead(string $id)
    {
        $this->notificationService->setAsRead($id);

        return ApiResponse::success();
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAllAsRead()
    {
        $this->notificationService->setAllAsRead();

        return ApiResponse::success();
    }
}
