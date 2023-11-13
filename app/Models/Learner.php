<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;


    protected $table = 'learners';
    protected $primaryKey = 'learner_id';

    protected $fillable = [
        'grade_level',
        'is_returnee',
        'lrn',
        'psa_cert_no',
        'lname',
        'fname',
        'mname',
        'extension',
        
        'sex',
        'birthdate',
        'birthplace',
        'age',
        'mother_tongue',
        'is_indigenous',
        'if_yes_indigenous',
        'is_4ps',
        'household_4ps_id_no',

        'current_country',
        'current_province',
        'current_city',
        'current_barangay',
        'current_street',
        'current_zipcode',

        'permanent_country',
        'permanent_province',
        'permanent_city',
        'permanent_barangay',
        'permanent_street',
        'permanent_zipcode',

        'email',
        'contact_no',

        'father_lname',
        'father_fname',
        'father_mname',
        'father_extension',
        'father_contact_no',
        
        'mother_maiden_lname',
        'mother_maiden_fname',
        'mother_maiden_mname',
        'mother_maiden_contact_no',

        'guardian_lname',
        'guardian_fname',
        'guardian_mname',
        'guardian_extension',
        'guardian_contact_no',

        'last_grade_level_completed',
        'last_school_year_completed',
        'last_school_attended',
        'last_schoold_id',

        'semester_id',
        'senior_high_school_id',
        'track_id',
        'strand_id',

    ];


    public function semester(){
        return $this->hasOne(Semester::class, 'semester_id', 'semester_id');
    }

    public function strand(){
        return $this->hasOne(Strand::class, 'strand_id', 'strand_id');
    }

    public function track(){
        return $this->hasOne(Track::class, 'track_id', 'track_id');
    }


    public function current_province(){
        return $this->hasOne(Province::class, 'provCode', 'current_province');
    }
    public function current_city(){
        return $this->hasOne(City::class, 'citymunCode', 'current_city');
    }
    public function current_barangay(){
        return $this->hasOne(Barangay::class, 'brgyCode', 'current_barangay');
    }

    public function permanent_province(){
        return $this->hasOne(Province::class, 'provCode', 'permanent_province');
    }
    public function permanent_city(){
        return $this->hasOne(City::class, 'citymunCode', 'permanent_city');
    }
    public function permanent_barangay(){
        return $this->hasOne(Barangay::class, 'brgyCode', 'permanent_barangay');
    }



}
