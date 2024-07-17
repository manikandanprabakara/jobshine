<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class EmploymentHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'jobseeker_id','employer_org_name', 'title', 'company', 'from', 'to', 'description', 'leaving_reason'
    ];



    public function jobseeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }

    public function posistionHistories()
    {
        return $this->hasMany(PosistionHistory::class);
    }

    public function  positionHistories()
    {
        return $this->hasMany(PosistionHistory::class);
    }
}

