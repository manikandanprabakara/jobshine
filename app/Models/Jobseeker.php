<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobseeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'employer_id', 'full_name', 'date_parsed', 'phone', 'work_experience', 'education','year_of_birth','visa_all', 'visa_sg', 'visa_my', 'visa_f', 'visa_ep', 'visa_wp', 'visa_sp','visa_ltvp','visa_dp', 'zip_code', 'phone_cleaned', 'dropbox_resume_id', 'has_shown_irratic_behaviour', 'resume_url', 'num_year_of_birth','sovren_raw_results','sovren_resume_summary','sovren_resume_parsing_failed','resume_id','jobseeker_id','location','resume_owner','dropbox_resume_url', 'fastjobs_job_title', 'previously_revealed', 'have_phone', 'last_activity'
    ];



    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    

}
