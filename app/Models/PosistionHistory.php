<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosistionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'employment_history_id', 'position_type', 'title', 'organization_name', 
        'description', 'start_date','end_date',
    ];

    public function employmentHistory(){
        return $this->belongsTo(EmploymentHistory::class);
    }

    public function jobCategory()
    {
        return $this->hasMany(JobCategory::class);
    }
}


 


