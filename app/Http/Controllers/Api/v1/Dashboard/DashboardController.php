<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Occupant;
use App\Models\Room;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $occupiedRooms = Room::whereStatus('occupied')->count();

            $vacantRooms = Room::whereStatus('available')->count();

            return $this->successResponse([
                'total_buildings' => Building::count(),
                'total_rooms' => Room::count(),
                'occupied_rooms' => $occupiedRooms,
                'vacant_rooms' => $vacantRooms,
                'total_occupants' => Occupant::count(),

                'room_status_summary' => [
                    'available' => Room::whereStatus('available')->count(),
                    'occupied' => Room::whereStatus('occupied')->count(),
                    'reserved' => Room::whereStatus('reserved')->count(),
                    'blocked' => Room::whereStatus('blocked')->count(),
                    'maintenance' => Room::whereStatus('maintenance')->count(),
                ]
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to fetch dashboard data',
                $th->getMessage(),
                500
            );
        }
    }
}
