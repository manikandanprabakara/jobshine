<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $fillable = [
        'jobseeker_id', 'university_institution', 'degree_speciality', 'from', 'to', 'description'
    ];

    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }

}
