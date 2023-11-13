<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username', 
        'password',
        'email',
        'contact_no',

        'lrn',
        'lname', 
        'fname', 
        'mname', 
        'suffix', 
        'sex',
        'bdate',
        'age',
        'birthplace',
        'mother_tongue',

        'is_indigenous',
        'if_yes_indigenous',
        'is_4ps',
        'household_4ps_id_no',

        'current_province', 'current_city', 
        'current_barangay', 'current_street',
        'current_zipcode',

        'permanent_province', 'permanent_city', 
        'permanent_barangay', 'permanent_street',
        'permanent_zipcode',

        'father_lname',
        'father_fname',
        'father_mname',
        'father_contact_no',

        'mother_maiden_lname',
        'mother_maiden_fname',
        'mother_maiden_mname',
        'mother_maiden_contact_no',

        'guardian_lname',
        'guardian_fname',
        'guardian_mname',
        'guardian_contact_no',

        'role',

        'semester_id',
        'strand_id',
        'track_id'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

    
}
