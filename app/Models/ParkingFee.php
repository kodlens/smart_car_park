<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingFee extends Model
{
    use HasFactory;


    
    protected $table = 'park_reservations';
    protected $primaryKey = 'parking_reservation_id';

    protected $fillable = [
        'hour',
        'price',
        'user_id',
        'park_id',
        'start_time',
        'end_time',
        'enter_time',
        'exit_time',
        'qr_ref'
    ];

    


}
