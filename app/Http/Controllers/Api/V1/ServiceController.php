<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Service::query()->where('is_active', true);

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        $services = $query->latest()->paginate($request->integer('per_page', 15));

        return $this->success(ServiceResource::collection($services), 'Services retrieved successfully');
    }

    public function show(Service $service)
    {
        return $this->success(new ServiceResource($service), 'Service retrieved successfully');
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        return $this->success(new ServiceResource($service), 'Service created successfully', 201);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return $this->success(new ServiceResource($service->refresh()), 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return $this->success(null, 'Service deleted successfully');
    }
}
