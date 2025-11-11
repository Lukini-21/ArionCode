<?php

namespace App\Http\Middleware;

use App\Support\Auth\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class MockAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/auth/*')) {
            return $next($request);
        }
        try {
            $token = $request->bearerToken();

            if ($token) {
                $payload = JWT::decode(
                    $token,
                    new Key(env('AUTH_JWT_SECRET', 'local_dev_secret'), 'HS256')
                );

                $user = User::getByField("email", $payload->email);

                if ($user) {
                    $user->orgId =  $payload->orgId ?? null;
                    $user->roles =  $payload->roles ?? null;
                    Auth::setUser($user);
                    return $next($request);
                }
            }
            throw new \Exception();
        } catch (\Throwable) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
