<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;


    protected $table = 'academic_years';
    protected $primaryKey = 'academic_year_id';

    protected $fillable = ['academic_year_code',
        'academic_year_desc',
        'is_active'
    ];

}
