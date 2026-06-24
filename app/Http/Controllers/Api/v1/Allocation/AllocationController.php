<?php

namespace App\Http\Controllers\Api\v1\Allocation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Allocation\StoreAllocationRequest;
use App\Http\Requests\Allocation\UpdateAllocationRequest;
use App\Http\Resources\AllocationResource;
use App\Models\Allocation;
use App\Models\Occupant;
use App\Models\Room;
use App\Services\AllocationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $allocations = Allocation::with([
                'room.building',
                'occupant'
            ])
                ->latest()
                ->paginate();

            return $this->successResponse(
                AllocationResource::collection(
                    $allocations
                ),
                'Allocations fetched successfully'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to fetch allocations',
                $th->getMessage(),
                500
            );
        }
    }

    public function store(StoreAllocationRequest $request, AllocationService $allocationService)
    {
        try {
            $room = Room::findOrFail(
                $request->room_id
            );

            $occupant = Occupant::findOrFail(
                $request->occupant_id
            );

            $allocation = $allocationService->allocate($room, $occupant);

            return $this->successResponse(
                new AllocationResource(
                    $allocation->load(
                        'room.building',
                        'occupant'
                    )
                ),
                'Occupant allocated successfully',
                201
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to allocate occupant',
                $th->getMessage(),
                500
            );
        }
    }

    public function show(Allocation $allocation)
    {
        try {
            return $this->successResponse(
                new AllocationResource(
                    $allocation->load(
                        'room.building',
                        'occupant'
                    )
                ),
                'Allocation details fetched'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to fetch allocation details',
                $th->getMessage(),
                500
            );
        }
    }

    public function update(UpdateAllocationRequest $request, Allocation $allocation, AllocationService $allocationService)
    {
        $room = Room::findOrFail(
            $request->room_id
        );

        $allocation = $allocationService->transfer($allocation, $room);

        return $this->successResponse(
            new AllocationResource(
                $allocation
            ),
            'Allocation transferred successfully.'
        );
    }

    public function destroy(Allocation $allocation, AllocationService $allocationService)
    {
        $allocation->update([
            'status' => 'cancelled'
        ]);

        $allocationService
            ->updateRoomStatus(
                $allocation->room
            );

        return $this->successResponse(
            null,
            'Allocation cancelled successfully'
        );
    }
}
