<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    use HasFactory;

    protected $table = 'room_status';

    protected $fillable = [
        'status_name'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'status_id');
    }
} 