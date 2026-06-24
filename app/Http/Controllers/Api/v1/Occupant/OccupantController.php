<?php

namespace App\Http\Controllers\Api\v1\Occupant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Occupant\StoreOccupantRequest;
use App\Http\Requests\Occupant\UpdateOccupantRequest;
use App\Http\Resources\OccupantResource;
use App\Models\Occupant;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OccupantController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $occupants = Occupant::latest()->paginate(10);

            return $this->successResponse(
                OccupantResource::collection($occupants),
                'Occupants fetched successfully'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to fetch occupants',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOccupantRequest $request)
    {
        try {
            $data = $request->validated();
            $occupant = Occupant::create($data);

            return $this->successResponse(
                new OccupantResource($occupant),
                'Occupant created successfully',
                201
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to create occupant',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Occupant $occupant)
    {
        try {
            return $this->successResponse(
                new OccupantResource($occupant),
                'Occupant details fetched'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to fetch occupant details',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOccupantRequest $request, Occupant $occupant)
    {
        try {
            $data = $request->validated();

            $occupant->update($data);

            return $this->successResponse(
                new OccupantResource($occupant),
                'Occupant updated successfully'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to update occupant',
                $th->getMessage(),
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occupant $occupant)
    {
        try {
            $occupant->delete();

            return $this->successResponse(
                null,
                'Occupant deleted successfully'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to delete occupant',
                $th->getMessage(),
                500
            );
        }
    }
}
