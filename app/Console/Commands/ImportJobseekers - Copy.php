<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\{Jobseeker,EmploymentHistory,Education};

class ImportJobseekers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:jobseekers {input_file_path}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folderPath = $this->argument('input_file_path');

        // Check if the folder exists
        if (!File::exists($folderPath)) {
            $this->error("Folder not found: $folderPath");
            return;
        }

        // Get all files in the folder
        $files = File::glob("$folderPath/*.txt");
        foreach ($files as $file) {
            $this->info("Processing file: $file");

            // Read the file contents (assuming JSON format)
            $contents = File::get($file);
            $data = json_decode($contents, true);

            // Import jobseekers logic
            foreach ($data['data'] as $item) {
                
                    $jobseeker = Jobseeker::updateOrCreate(
                        ['jobseeker_id' => $item['jobseeker_id']],
                        [
                            'id'=>$item['id'],
                            'email' => $item['email'],
                            'full_name' => $item['full_name'],
                            'date_parsed' => $item['date_parsed'],
                            'phone' => $item['phone'],
                            'work_experience' => json_encode($item['work_experience']),
                            'education' => json_encode($item['education']),
                            'year_of_birth' => $item['year_of_birth'],
                            'visa_all' => $item['visa_all'],
                            'visa_sg' => $item['visa_sg'],
                            'visa_my' => $item['visa_my'],
                            'visa_f' => $item['visa_f'],
                            'visa_ep' => $item['visa_ep'],
                            'visa_wp' => $item['visa_wp'],
                            'visa_sp' => $item['visa_sp'],
                            'visa_ltvp' => $item['visa_ltvp'],
                            'visa_dp' => $item['visa_dp'],
                            'zip_code' => $item['zip_code'],
                            'phone_cleaned' => $item['phone_cleaned'],
                            'dropbox_resume_id' => $item['dropbox_resume_id'],
                            'has_shown_irratic_behaviour' => $item['has_shown_irratic_behaviour'],
                            'resume_url' => $item['resume_url'],
                            'num_year_of_birth' => $item['num_year_of_birth'],
                            'sovren_raw_results' => $item['sovren_raw_results'],
                            'sovren_resume_summary' => $item['sovren_resume_summary'],
                            'sovren_resume_parsing_failed' => $item['sovren_resume_parsing_failed'],
                            'resume_id' => $item['resume_id'],
                            'jobseeker_id' => $item['jobseeker_id'],
                            'location' => $item['location'],
                            'resume_owner' => $item['resume_owner'],
                            'dropbox_resume_url' => $item['dropbox_resume_url'],
                            'fastjobs_job_title' => $item['fastjobs_job_title'],
                            'previously_revealed' => $item['previously_revealed'],
                            'have_phone' => $item['have_phone'],
                            'last_activity' => $item['last_activity'],

                        ]
                    );

                    if (isset($item['employment_history'])) {
                        foreach ($item['employment_history'] as $history) {
                            foreach ($history['PositionHistory'] as $position) {
                                EmploymentHistory::updateOrCreate(
                                    [
                                        'jobseeker_id' => $jobseeker->id,
                                        'title' => $position['Title'],
                                    ],
                                    [
                                        'company' => $history['EmploymentOrgName'],
                                        // Add other fields as needed
                                    ]
                                );
                            }
                        }
                    }


                // Import education details
                if (isset($item['education'])) {
                    $educations = json_decode($item['education'], true);
                    if (is_array($educations)) {
                        foreach ($educations  as $education) {
                            Education::updateOrCreate(
                                [
                                    'jobseeker_id' => $jobseeker->id,
                                    'degree_speciality' => $education['degree_speciality'],
                                ],
                                [
                                    'university_institution' => $education['university_institution'],
                                    'from' => $education['from'],
                                    'to' => $education['to'],
                                    'description' => $education['description'],
                                ]
                            );
                        }
                    }
                }
                


            }

            $this->info("Import from $file completed.");
        }

        $this->info('All files processed successfully!');
    }
}
