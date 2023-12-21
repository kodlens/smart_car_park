<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];


}
