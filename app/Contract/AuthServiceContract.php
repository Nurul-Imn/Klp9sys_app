<?php

namespace App\Contract;

interface AuthServiceContract
{
    public function register(array $data): array;

    public function login(string $email, string $password): ?string;

    public function logout(int $userId): bool;

    public function getUserProfile(int $userId): array;

    public function updateUserProfile(int $userId, array $profileData): bool;

    public function getUserPets(int $userId): array;

    public function saveUserPet(int $userId, array $petData): bool;
}
