<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrandCourse extends Model
{
    use HasFactory;


    protected $table = 'strand_courses';
    protected $primaryKey = 'strand_course_id';

    protected $fillable = [
        'strand_id',
        'course_id',
    ];

    public function course(){
        return $this->hasOne(Course::class, 'course_id', 'course_id');
    }



}
