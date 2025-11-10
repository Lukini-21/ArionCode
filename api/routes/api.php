<?php

use App\Http\Controllers\Api\{Auth\AuthController,
    NotificationController,
    OrganizationController,
    ProjectController,
    SwitchController,
    TaskController};
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Healthcheck
Route::get('/health', fn () => ['status' => 'ok']);
Route::post('/switch', [SwitchController::class, 'switch']);

// Resource routes
Route::apiResources([
    'organizations' => OrganizationController::class,
    'projects' => ProjectController::class,
    'tasks' => TaskController::class,
    'notifications' => NotificationController::class,
]);

Route::prefix('projects')->group(function () {
    Route::post('/{project}/set-status', [ProjectController::class, 'setStatus']);
    Route::post('/{project}/assign-members', [ProjectController::class, 'assignMembers']);
});

Route::prefix('tasks')->group(function () {
    Route::post('/{task}/set-status', [TaskController::class, 'setStatus']);
    Route::post('/{task}/add-comment', [TaskController::class, 'addComment']);
});

Route::prefix('notifications')->group(function () {
    Route::post('/{notification}/set-as-read', [NotificationController::class, 'setAsRead']);
});
