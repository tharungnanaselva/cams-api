<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Allocation;
use App\Models\Occupant;
use Illuminate\Validation\ValidationException;

class AllocationService
{
    public function allocate(Room $room, Occupant $occupant): Allocation
    {

        $alreadyAllocated = Allocation::where('occupant_id', $occupant->id)
            ->where('status', 'active')
            ->exists();

        if ($alreadyAllocated) {
            throw ValidationException::withMessages([
                'occupant' => [
                    'Occupant already allocated.'
                ]
            ]);
        }

        $occupancy = Allocation::where('room_id', $room->id)
            ->where('status', 'active')
            ->count();

        if ($occupancy >= $room->capacity) {
            throw ValidationException::withMessages([
                'room' => [
                    'Room capacity exceeded.'
                ]
            ]);
        }

        if ($room->gender_restriction !== 'mixed' && $room->gender_restriction !== $occupant->gender) {
            throw ValidationException::withMessages([
                'gender' => [
                    'Gender restricted.'
                ]
            ]);
        }

        $allocation = Allocation::create([
            'room_id' => $room->id,
            'occupant_id' => $occupant->id,
            'allocated_at' => now(),
            'status' => 'active'
        ]);

        $this->updateRoomStatus($room);

        return $allocation;
    }

    public function transfer(Allocation $allocation, Room $newRoom): Allocation
    {
        $occupant = $allocation->occupant;

        $occupancy = Allocation::where('room_id', $newRoom->id)
            ->where('status', 'active')
            ->count();

        if ($occupancy >= $newRoom->capacity) {

            throw ValidationException::withMessages([
                'room' => [
                    'Room capacity exceeded.'
                ]
            ]);
        }

        if ($newRoom->gender_restriction !== 'mixed' && $newRoom->gender_restriction !== $occupant->gender) {

            throw ValidationException::withMessages([
                'gender' => [
                    'Gender restricted room.'
                ]
            ]);
        }

        $oldRoom = $allocation->room;

        $allocation->update([
            'room_id' => $newRoom->id
        ]);

        $this->updateRoomStatus($oldRoom);
        $this->updateRoomStatus($newRoom);

        return $allocation->fresh([
            'room',
            'occupant'
        ]);
    }

    public function updateRoomStatus(Room $room): void
    {
        $occupancy = Allocation::where('room_id', $room->id)
            ->where('status', 'active')
            ->count();

        $room->update([
            'status' =>
            $occupancy >= $room->capacity
                ? 'occupied'
                : 'available'
        ]);
    }
}
