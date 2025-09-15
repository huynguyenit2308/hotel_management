<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'room';

    protected $fillable = [
        'room_number',
        'room_type',
        'price',
        'status_id'
    ];

    public function status()
    {
        return $this->belongsTo(RoomStatus::class, 'status_id');
    }
} 