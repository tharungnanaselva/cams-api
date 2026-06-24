<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allocation extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'room_id',
        'occupant_id',
        'allocated_at',
        'status'
    ];

    protected $casts = [
        'allocated_at' => 'datetime'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function occupant()
    {
        return $this->belongsTo(Occupant::class);
    }
}
