<?php

namespace App\Http\Controllers\Api\V1;

use App\Contract\AuthServiceContract;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PetRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\PetResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private AuthServiceContract $authService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return $this->success(new UserResource($user), 'Registration successful', 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->email, $request->password);

        if (! $result) {
            return $this->error('These credentials do not match our records.', 401);
        }

        return $this->success([
            'token' => $result['token'],
            'user' => new UserResource($result['user']),
        ], 'Login successful');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logged out successfully');
    }

    public function profile(Request $request)
    {
        $user = $this->authService->getUserProfile($request->user());

        return $this->success(new UserResource($user), 'Profile retrieved successfully');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->authService->updateUserProfile($request->user(), $request->validated());

        return $this->success(new UserResource($user), 'Profile updated successfully');
    }

    public function pets(Request $request)
    {
        $pets = $this->authService->getUserPets($request->user());

        return $this->success(PetResource::collection($pets), 'Pets retrieved successfully');
    }

    public function savePet(PetRequest $request)
    {
        $pet = $this->authService->saveUserPet($request->user(), $request->validated());

        return $this->success(new PetResource($pet), 'Pet saved successfully', 201);
    }
}
