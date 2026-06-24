<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'building_id',
        'room_number',
        'room_type',
        'gender_restriction',
        'status',
        'capacity',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}
