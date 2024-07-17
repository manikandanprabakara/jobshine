<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobseekers', function (Blueprint $table) {
            $table->id();
            $table->integer('employer_id')->nullable();
            $table->string('email')->nullable();
            $table->string('full_name')->nullable();
            $table->string('date_parsed')->nullable();
            $table->string('phone')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('education')->nullable();
            $table->string('year_of_birth')->nullable();
            $table->boolean('visa_all')->default(false);
            $table->boolean('visa_sg')->default(false);
            $table->boolean('visa_my')->default(false);
            $table->boolean('visa_f')->default(false);
            $table->boolean('visa_ep')->default(false);
            $table->boolean('visa_wp')->default(false);
            $table->boolean('visa_sp')->default(false);
            $table->boolean('visa_ltvp')->default(false);
            $table->boolean('visa_dp')->default(false);
            $table->string('zip_code')->nullable();
            $table->string('phone_cleaned')->nullable();
            $table->integer('dropbox_resume_id')->nullable();
            $table->string('has_shown_irratic_behaviour')->nullable();
            $table->text('resume_url')->nullable();
            $table->string('num_year_of_birth')->nullable();
            $table->string('sovren_raw_results')->nullable();
            $table->string('sovren_resume_summary')->nullable();
            $table->string('sovren_resume_parsing_failed')->nullable();
            $table->integer('resume_id')->nullable();
            $table->integer('jobseeker_id')->nullable();
            $table->string('location')->nullable();
            $table->string('resume_owner')->nullable();
            $table->string('dropbox_resume_url')->nullable();
            $table->string('fastjobs_job_title')->nullable();
            $table->boolean('previously_revealed')->default(true);
            $table->boolean('have_phone')->default(true);
            $table->string('last_activity')->nullable();
            //starts Newemployee floder
            $table->decimal('desired_salary_cleaned', 10, 2)->nullable();
            $table->boolean('is_physically_present')->default(false);
            $table->boolean('job_admin')->default(false);
            $table->boolean('job_covid19')->default(false);
            $table->boolean('job_customerservice')->default(false);
            $table->boolean('job_distributionshipping')->default(false);
            $table->boolean('job_grocery')->default(false);
            $table->boolean('job_marketingsales')->default(false);
            $table->boolean('job_other')->default(false);
            $table->boolean('job_production')->default(false);
            $table->boolean('job_restaurantfoodservice')->default(false);
            $table->boolean('job_retail')->default(false);
            $table->boolean('job_supplychain')->default(false);
            $table->boolean('job_transportation')->default(false);
            $table->boolean('job_warehouse')->default(false);
            $table->string('picked_up_phone')->nullable();
            $table->string('personal_summary')->nullable();
            $table->text('skills')->nullable();
            $table->boolean('job_hospitalityhotel')->default(false);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobseekers');
    }
};
