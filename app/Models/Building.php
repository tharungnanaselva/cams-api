<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type', 'gender_restriction', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

}
