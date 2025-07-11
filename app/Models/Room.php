<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['hotel_id', 'nombre', 'num_max_personas', 'camas', 'costo_noche'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'room_service');
    }
}