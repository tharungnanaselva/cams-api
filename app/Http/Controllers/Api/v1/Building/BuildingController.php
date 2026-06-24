<?php

namespace App\Http\Controllers\Api\v1\Building;

use App\Http\Controllers\Controller;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $buildings = Building::latest()->paginate(10);

            return $this->successResponse(
                BuildingResource::collection($buildings),
                'Buildings fetched successfully'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to fetch buildings',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request)
    {
        try {
            $building = Building::create(
                $request->validated()
            );

            return $this->successResponse(
                new BuildingResource($building),
                'Building created successfully',
                201
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to create building',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        try {
            return $this->successResponse(
                new BuildingResource($building),
                'Building details fetched'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to fetch building',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building)
    {
        try {
            $building->update(
                $request->validated()
            );

            return $this->successResponse(
                new BuildingResource($building),
                'Building updated successfully'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to update building',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        try {
            $building->delete();

            return $this->successResponse(
                null,
                'Building deleted successfully'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to delete building',
                $th->getMessage(),
                500
            );
        }
    }
}
