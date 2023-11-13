<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrol extends Model
{
    use HasFactory;

    protected $table = 'enrols';
    protected $primaryKey = 'enrol_id';


    protected $fillable = [
        'academic_year_id',
        'grade_level',
        'is_returnee',
        'learner_id',
        'section_id',
        'semester_id',
        'track_id',
        'strand_id',
        'date_enroled',
        'section_id',
        'section'
    ];

    public function academic_year(){
        return $this->hasOne(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function learner(){
        return $this->hasOne(Learner::class, 'learner_id', 'learner_id');
    }

    public function semester(){
        return $this->hasOne(Semester::class, 'semester_id', 'semester_id');
    }

    public function track(){
        return $this->hasOne(Track::class, 'track_id', 'track_id');
    }

    public function strand(){
        return $this->hasOne(Strand::class, 'strand_id', 'strand_id');
    }

    public function section(){
        return $this->hasOne(Section::class, 'section_id', 'section_id');
    }
}
