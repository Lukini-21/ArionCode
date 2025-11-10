<?php

namespace App\Http\Controllers\Api;

use app\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationSwitchRequest;
use App\Support\Auth\User;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SwitchController extends Controller
{
    public function switch(OrganizationSwitchRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::getUser();
        $user = $user->toArray();
        $user['orgId'] = $request->get('orgId');

        $secret = env('AUTH_JWT_SECRET', 'local_dev_secret');
        $token = JWT::encode($user, $secret, 'HS256');

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ]);
    }
}