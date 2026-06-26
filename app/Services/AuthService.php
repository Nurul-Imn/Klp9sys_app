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
     * Register user baru
     */
    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'] ?? 'customer',
            'phone'    => $data['phone'] ?? null,
        ]);

        return $user->toArray();
    }

    /**
     * Login user
     */
    public function login(string $email, string $password): ?string
    {
        if (Auth::attempt([
            'email' => $email,
            'password' => $password,
        ])) {
            session()->regenerate();

            return session()->getId();
        }

        return null;
    }

    /**
     * Logout user
     */
    public function logout(int $userId): bool
    {
        if (!Auth::check()) {
            return false;
        }

        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return true;
    }

    /**
     * Ambil profil user
     */
    public function getUserProfile(int $userId): array
    {
        $user = User::find($userId);

        return $user ? $user->toArray() : [];
    }

    /**
     * Update profil user
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

        $user->update($profileData);

        return true;
    }

    /**
     * Ambil semua hewan milik user
     */
    public function getUserPets(int $userId): array
    {
        $user = User::find($userId);

        if (!$user) {
            return [];
        }

        return $user->pets()->get()->toArray();
    }

    /**
     * Simpan data hewan milik user
     */
    public function saveUserPet(int $userId, array $petData): bool
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        $user->pets()->create($petData);

        return true;
    }
}