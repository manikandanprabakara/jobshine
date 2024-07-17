<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{JobCategory, Jobseeker};
use Laravel\Scout\Builder;
use Yajra\DataTables\Facades\Datatables;
use DB;
use App\Http\Controllers\Carbon\Carbon;

class CandidateSearchController extends Controller
{

    public function view()
    {
        $jobCategories = JobCategory::where('taxonomy_name', 'Job Level')
            ->select('category_code')
            ->groupBy('category_code')
            ->get();
        $visaCategories = [
            'dp' => 'Visa DP',
            'ep' => 'Visa EP',
            'f' => 'Visa F',
            'ltvp' => 'Visa LTVP',
            'sg' => 'VISA SG',
            'my' => 'VISA MY',
            'wp' => 'VISA WP',
            'sp' => 'VISA SP',
            'all' => 'Visa All'
        ];
        return view('Candidate.view', compact('jobCategories', 'visaCategories'));
    }




    public function searchCandidates(Request $request)
    {
        // Start building the query
        $query = Jobseeker::query();

        // Apply filters based on request parameters
        if ($request->filled('name')) {
            $query->where('full_name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
        if ($request->filled('age')) {
            $age = $request->input('age');
            if (is_numeric($age) && $age > 0) {
                $currentYear = now()->year;
                $yearOfBirthStart = $currentYear - $age;
                $yearOfBirthEnd = $currentYear - $age - 1;
                $query->whereBetween('year_of_birth', [$yearOfBirthEnd, $yearOfBirthStart]);
            }
        }
        if ($request->filled('salary_min') || $request->filled('salary_max')) {
            $minSalary = $request->input('salary_min', 0);
            $maxSalary = $request->input('salary_max', PHP_INT_MAX);
            if (is_numeric($minSalary) && is_numeric($maxSalary)) {
                $query->whereBetween('desired_salary_cleaned', [$minSalary, $maxSalary]);
            }
        }
        if ($request->filled('visa_category')) {
            $visaCategory = $request->input('visa_category');
            $visaField = 'visa_' . $visaCategory;
            $query->where($visaField, true);
        }
        return DataTables::of($query)
            ->addColumn('age', function ($jobseeker) {
                $currentYear = now()->year;
                $yearOfBirth = (int) $jobseeker->year_of_birth;
                if (is_numeric($yearOfBirth)) {
                    return $currentYear - $yearOfBirth;
                }
                return 'N/A'; // Return 'N/A' if year_of_birth is not numeric
            })
            ->addColumn('desired_salary', function ($jobseeker) {
                return $jobseeker->desired_salary_cleaned;
            })
            ->addColumn('visa_category', function ($jobseeker) {
                $visaCategories = [
                    'dp' => 'Visa DP',
                    'ep' => 'Visa EP',
                    'f' => 'Visa F',
                    'ltvp' => 'Visa LTVP',
                    'sg' => 'VISA SG',
                    'my' => 'VISA MY',
                    'wp' => 'VISA WP',
                    'sp' => 'VISA SP',
                    'all' => 'Visa All'
                ];

                foreach ($visaCategories as $key => $label) {
                    $field = 'visa_' . $key;
                    if ($jobseeker->$field) {
                        return $label;
                    }
                }
                return 'N/A'; // Return 'N/A' if no visa category is true
            })
            ->addColumn('work_experience', function ($jobseeker) {
                $totalExperience = 0;
                $workExperience = json_decode($jobseeker->work_experience, true);

                if (is_array($workExperience)) {
                    foreach ($workExperience as $experience) {
                        $from = Carbon\Carbon::parse($experience['from']);
                        $to = Carbon\Carbon::parse($experience['to']);
                        $totalExperience += $to->diffInMonths($from);
                    }
                }

                return round($totalExperience / 12, 1) . ' years'; // Convert months to years and format
            })
            ->addColumn('job_titles', function ($jobseeker) {
                $employmentHistories = $jobseeker->employmentHistories;
                $jobTitles = [];

                foreach ($employmentHistories as $employmentHistory) {
                    $positionHistories = $employmentHistory->positionHistories;
                    foreach ($positionHistories as $positionHistory) {
                        $jobTitles[] = $positionHistory->title;
                    }
                }

                return implode(', ', $jobTitles); // Concatenate job titles with commas
            })
            ->addColumn('actions', function ($jobseeker) {
                return '<a  class="btn btn-sm btn-primary view-details" onclick="onclickssss('.$jobseeker->id.')" data-id="'.$jobseeker->id.'">View</a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function show($id){
        $jobseeker = Jobseeker::findOrFail($id);
    
        return response()->json($jobseeker);
    }
}
