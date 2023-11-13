<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strand extends Model
{
    use HasFactory;


    protected $table = 'strands';
    protected $primaryKey = 'strand_id';

    protected $fillable = ['track_id', 'strand', 'strand_desc'];

    public function track(){
        return $this->belongsTo(Track::class, 'track_id', 'track_id');
    }
    public function courses(){
        return $this->hasMany(StrandCourse::class, 'strand_id', 'strand_id');
    }


    

}
