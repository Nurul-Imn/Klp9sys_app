<?php

namespace App\Services;

use App\Contract\AuthServiceContract;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceContract
{
    /**
     * Register a new user.
     */
    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'role'     => 'customer',
        ]);

        return $user->toArray();
    }

    /**
     * Attempt to log the user in. Returns the user's name on success, null on failure.
     */
    public function login(string $email, string $password): ?string
    {
        $credentials = ['email' => $email, 'password' => $password];

        if (!Auth::attempt($credentials)) {
            return null;
        }

        return Auth::user()->name;
    }

    /**
     * Log the user out (session-based — nothing extra needed beyond the controller).
     */
    public function logout(int $userId): bool
    {
        Auth::logout();
        return true;
    }

    /**
     * Return user profile data as an array.
     */
    public function getUserProfile(int $userId): array
    {
        $user = User::findOrFail($userId);
        return $user->toArray();
    }

    /**
     * Update user profile fields.
     */
    public function updateUserProfile(int $userId, array $profileData): bool
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        if (isset($profileData['password'])) {
            $profileData['password'] = Hash::make($profileData['password']);
        }

        return $user->update($profileData);
    }

    /**
     * Return all pets belonging to a user.
     */
    public function getUserPets(int $userId): array
    {
        return Pet::where('user_id', $userId)->get()->toArray();
    }

    /**
     * Create or update a pet for the given user.
     */
    public function saveUserPet(int $userId, array $petData): bool
    {
        $petData['user_id'] = $userId;

        if (!empty($petData['id'])) {
            $pet = Pet::where('id', $petData['id'])->where('user_id', $userId)->first();
            if (!$pet) {
                return false;
            }
            return (bool) $pet->update($petData);
        }

        Pet::create($petData);
        return true;
    }
}
