<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkReservation extends Model
{
    use HasFactory;
    protected $table = 'park_reservations';
    protected $primaryKey = 'park_reservation_id';

    protected $fillable = [
        'hour',
        'price',
        'user_id',
        'park_id',
        'start_time',
        'end_time',
        'enter_time',
        'exit_time',
        'qr_ref',
        'remarks',
        'active'
    ];

    public function user(){
        return $this->hasOne(User::class, 'user_id','user_id');
    }

    public function park(){
        return $this->hasOne(Park::class, 'park_id', 'park_id');
    }
}
