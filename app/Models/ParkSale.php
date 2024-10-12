<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkSale extends Model
{
    protected $fillable = [
        'remarks', 
        'price', 
        'transaction_date', 
        'park_reservation_id',
        'user_id',
        'park_id'
    ];


    public function reservation_park(){
        return $this->hasOne(ParkSale::class, 'park_reservation_id', 'park_reservation_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}
