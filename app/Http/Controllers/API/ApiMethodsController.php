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

    public function metData()
    {
        $languages = Language::all();
        $job_shifts = JobShift::orderBy('sort_order', 'asc')->get();
        $trainings = Training::orderBy('sort_order', 'asc')->get();
        $skills = Skill::orderBy('sort_order', 'asc')->get();
        $experience_levels = ExperienceLevel::orderBy('sort_order', 'asc')->get();
        $education_level = EducationLevel::orderBy('sort_order', 'asc')->get();
        $industries = Industry::where('is_active', 1)->get();
        $job_categories = JobCategory::where('is_active', 1)->orderBy('sort_order', 'asc')->get();

        return $this->sendResponse(compact(
            'languages',
            'job_shifts',
            'trainings',
            'skills',
            'experience_levels',
            'education_level',
            'industries',
            'job_categories'
        ),"success");
    }
}
