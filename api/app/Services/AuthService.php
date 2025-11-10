<?php

namespace App\Services;
/**
 *
 */
class AuthService
{
    /**
     * @param string $email
     * @return array
     */
    public function getMockedUser(string $email): array
    {
        return collect(config('demo.users', []))
                ->filter(fn($user) => isset($user['email']) && $user['email'] === $email)
                ->firstOrFail();
    }
}