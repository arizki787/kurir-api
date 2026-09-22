<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    /** @use HasFactory<\Database\Factories\CourierFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'level', 'vehicle_type',
        'vehicle_plate_number', 'license_number', 'address',
        'status', 'joined_at',
    ];

    protected function casts(): array
    {
        return[
            'level'     => 'integer',
            'joined_at' => 'date',
        ];
    }
}
