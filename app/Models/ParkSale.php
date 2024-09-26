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
        'park_reservation_id'
    ];
}
