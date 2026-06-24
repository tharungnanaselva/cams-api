<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

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
}
