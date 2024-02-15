<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ParkingFee;

class Park extends Model
{
    use HasFactory;

      
    protected $table = 'parks';
    protected $primaryKey = 'park_id';

    protected $fillable = [
        'name',
        'device_mac',
        'device_ip',
        'is_occupied',
        'user_id'
    ];

    public function parkReservation(){
        return $this->hasMany(ParkReservation::class, 'park_id', 'park_id');
    }
}
