<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\ExperienceLevel;
use App\Models\Industry;
use App\Models\JobCategory;
use App\Models\JobShift;
use App\Models\Language;
use App\Models\Skill;
use App\Models\Training;
use App\Traits\Api\ApiMethods;
use Illuminate\Http\Request;

class ApiMethodsController extends Controller
{
    use ApiMethods;

    public function MetData()
    {
        $data = array();
        $languages = Language::all();
        $data["languages"] =  $languages;

        $job_shifts = JobShift::orderBy('sort_order', 'asc')->get();
        $data["job_shifts"] = $job_shifts;

        $trainings = Training::orderBy('sort_order', 'asc')->get();
        $data["trainings"] = $trainings;

        $skills = Skill::orderBy('sort_order', 'asc')->get();
        $data["skills"] = $skills;

        $experience_levels = ExperienceLevel::orderBy('sort_order', 'asc')->get();
        $data["experience"] = $experience_levels;

        $education_level = EducationLevel::orderBy('sort_order', 'asc')->get();
        $data["education"] = $education_level;

        $industries = Industry::where('is_active', 1)->get();
        $data["industries"] = $industries;

        $job_categories = JobCategory::where('is_active', 1)->orderBy('sort_order', 'asc')->get();
        $data["job_categories"]= $job_categories;

      
        $result = $this->sendResponse(compact(
            'languages',
            'job_shifts',
            'trainings',
            'skills',
            'experience_levels',
            'education_level',
            'industries',
            'job_categories'
        ), "success");
        return  $result;
    }
}
