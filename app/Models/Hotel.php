<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'nombre',
        'direccion',
        'contacto',
        'telefono',
        'categoria',
        // .. otros campos existentes ..
        'latitude',
        'longitude'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }


}