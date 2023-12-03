<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingFee extends Model
{
    use HasFactory;


    
    protected $table = 'parking_fees';
    protected $primaryKey = 'parking_fee_id';

    protected $fillable = [
        'parking_hour',
        'parking_price',
    ];


}
