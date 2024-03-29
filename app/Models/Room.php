<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function roomStatus()
    {
        return $this->belongsTo(RoomStatus::class);
    }
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function roomItems()
    {
        return $this->hasMany(RoomItem::class);
    }
}
