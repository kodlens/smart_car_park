<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkPrice extends Model
{
    use HasFactory;


    protected $table = 'park_price';

    protected $fillable = [
        'park_price',
      
    ];

}
