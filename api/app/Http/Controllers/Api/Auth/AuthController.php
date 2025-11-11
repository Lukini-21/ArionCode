<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\OrganizationUser;
use App\Services\OrganizationService;
use App\Support\Auth\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @param OrganizationService $organizationService
     */
    public function __construct(
        private readonly OrganizationService $organizationService,
    )
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $user = User::getByField("email", $data['email']);

            if (!$user || $data['password'] !== $user->password) {
                throw new \Exception('Invalid credentials');
            }
            Auth::setUser($user);
            /** @var \Illuminate\Database\Eloquent\Collection<int, OrganizationUser> $organizations */
            $organizations = $this->organizationService->getUserAvailableOrganizations($user->uuid);

            if (!$organizations->count()) {
                throw new \Exception();
            }

            $authOrganization = $organizations->first();

            $payload = [
                'sub'   => $user->uuid,
                'email' => $user->email,
                'roles'  => $organizations->pluck('role'),
                'orgId' => $authOrganization->id,
                'exp'   => now()->addHours(4)->timestamp,
                'organizations' => $organizations->select(['id', 'name', 'role']),
            ];

            $secret = env('AUTH_JWT_SECRET', 'local_dev_secret');
            $token = JWT::encode($payload, $secret, 'HS256');

            return response()->json([
                'token' => $token,
                'user'  => $payload,
            ]);
        } catch (\Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = Auth::user() ?? $request->attributes->get('auth');
        return $user
            ? response()->json($user)
            : response()->json(['message' => 'Unauthenticated'], 401);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return response()->json(['message' => 'Logged out']);
    }
}
