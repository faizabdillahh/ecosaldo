<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as GoogleUserContract;

final class GoogleAuthService
{
    /**
     * Match existing user or create a new one from Google OAuth data.
     */
    public function handleGoogleUser(GoogleUserContract $googleUser): User
    {
        $user = $this->findExistingUser($googleUser);

        return $user
            ? $this->updateExistingUser($user, $googleUser)
            : $this->createNewUser($googleUser);
    }

    /**
     * Find user by Google ID or email.
     */
    private function findExistingUser(GoogleUserContract $googleUser): ?User
    {
        return User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();
    }

    /**
     * Update existing user with latest Google data.
     */
    private function updateExistingUser(User $user, GoogleUserContract $googleUser): User
    {
        $user->update([
            'google_id' => $googleUser->getId(),
        ]);

        return $user;
    }

    /**
     * Create a new user from Google OAuth data.
     */
    private function createNewUser(GoogleUserContract $googleUser): User
    {
        $user = User::create([
            'name'      => $googleUser->getName(),
            'email'     => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password'  => bcrypt(Str::random(32)),
        ]);

        $user->assignRole('nasabah');

        return $user;
    }
}