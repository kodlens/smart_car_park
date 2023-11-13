<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;


    protected $table = 'sections';
    protected $primaryKey = 'section_id';
    protected $fillable = ['track_id', 'strand_id', 'section', 'max'];



    public function track(){
        return $this->hasOne(Track::class, 'track_id', 'track_id');
    }

    public function strand(){
        return $this->hasOne(Strand::class, 'strand_id', 'strand_id');
    }


}
