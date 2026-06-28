<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    use ApiResponse;

    public function show(Request $request, Pet $pet)
    {
        $this->authorizeOwnership($request, $pet);

        return $this->success(new PetResource($pet), 'Pet retrieved successfully');
    }

    public function update(PetRequest $request, Pet $pet)
    {
        $this->authorizeOwnership($request, $pet);

        $pet->update($request->validated());

        return $this->success(new PetResource($pet->refresh()), 'Pet updated successfully');
    }

    public function destroy(Request $request, Pet $pet)
    {
        $this->authorizeOwnership($request, $pet);

        $pet->delete();

        return $this->success(null, 'Pet deleted successfully');
    }

    private function authorizeOwnership(Request $request, Pet $pet): void
    {
        $user = $request->user();

        if (! $user->isAdmin() && $pet->user_id !== $user->id) {
            abort(403, 'You are not allowed to access this pet.');
        }
    }
}
