<?php

namespace App\Models;

use App\Services\DateService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employe extends Model
{
    use HasFactory;
    protected $table = "employes";

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'gender',
        'marital_status',
        'nationality',
        'country_id',
        'state_id',
        'city_id',
        'tel_phone',
        'mobile_phone',
        'exprience_id',
        'user_id',
        'functional_area_id',
        'expected_salary',
        'salary_currency',
        'address',
        'is_active',
        'is_verified',
        'created_at',
        'updated_at',
        'avatar',
        'full_picture',
        'education_level_id',
        'dob_in_bs',
        'mobile_phone2',
        'district_id',
        'municipality',
        'ward',
        'passport_number',
        'passport_expiry_date',
        'is_experience',
        'trainings',
        'skills',
        'experiences',
        'languages',
        'height',
        'weight',
        'city_street',
        'bio',
        'website',
        'job_notify',
        'all_job_notify',
        'cv'
    ];





    // protected $hidden = [];

    protected $appends = [
        'full_name',
        'profile_score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getFullNameAttribute()
    {
        $middle_name = $this->middle_name != null ? $this->middle_name : '';
        return $this->first_name . ' ' . $middle_name . ' ' . $this->last_name;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function education_level()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    public function job_applications()
    {
        return $this->hasMany(JobApplication::class, 'employ_id');
    }

    public function experience()
    {
        return $this->hasMany(EmployeeExperience::class, 'employ_id');
    }

    public function job_preference()
    {
        return $this->hasOne(EmployJobPreference::class, 'employ_id');
    }

    // public function job_preferences()
    // {
    //     return $this->hasMany(EmployJobPreference::class, 'employ_id');
    // }

    public function job_preferences()
    {
        return $this->hasMany(JobPreference::class, 'employe_id');
    }

    public function employeeSkills()
    {
        return $this->hasMany(EmployeeSkill::class, 'employ_id');
    }

    public function employeeTrainings()
    {
        return $this->hasMany(EmployeeTraining::class, 'employee_id');
    }

    public function education()
    {
        return $this->hasMany(EmployeeEducation::class, 'employ_id');
    }

    public function employeeLanguage()
    {
        return $this->hasMany(EmployeeLanguage::class, 'employ_id');
    }

    public function preferredCountry()
    {
        return $this->hasMany(EmployesCountry::class, 'employ_id');
    }

    public function cv()
    {
        return $this->hasMany(EmployeeCv::class, 'employ_id');
    }

    public function getProfileScoreAttribute()
    {
        return $this->calculateProfileCompletion();
    }


    public function calculateProfileCompletion()
    {
        $completed = 0;
        $profileElements = ['first_name', 'last_name', 'dob', 'gender', 'marital_status',
         'state_id', 'district_id', 'mobile_phone', 'address', 'education_level_id', 'avatar', 'height', 'weight'];
        $total = count($profileElements);

        foreach($profileElements as $element){
            $completed += empty($this->{$element}) ? 0 : 1;
        }

        $countExperiences = DB::table('employes_experience')->where('employ_id', $this->id)->count();
        $countLanguages = DB::table('employes_languages')->where('employ_id', $this->id)->count();
        $countSkills = DB::table('employes_skills')->where('employ_id', $this->id)->count();
        $countPreferences = $this->job_preferences()->count();
        if($countExperiences > 0){
            $completed++;
        }
        if($countSkills > 0){
            $completed++;
        }
        if($countLanguages > 0){
            $completed++;
        }
        if($countPreferences > 0){
            $completed++;
        }
        $total = $total + 4;
        $completed = ($completed / $total) * 100;
        // dd($completed);
        return round($completed, 0);
    }



    public function preferredJobs($limit=10)
    {
        $jobs= [];
        $category = EmployJobPreference::where('employ_id', $this->id)->first();
        if ($category){
            $jobs = Job::with([
                'company', 'company.country', 'company.state', 'company.city',
                'country',
                'education_level',
                'jobExperience',
                'job_category',
                'jobShift'
            ])->where('job_categories_id', $category->job_category_id)->orWhere('country_id', $category->country_id)->limit($limit)->get();
        }
        return $jobs;
    }


    public function followings()
    {
        return $this->hasMany(CompanyFollower::class, "employ_id", "id");
    }


    public function calculateAgeFromDateOfBirth()
    {
        return (new DateService)->calculateAgeFromDateOfBirth($this->dob);
    }

    public function trainings()
    {
        return $this->hasMany(EmployeeTraining::class, 'employee_id');
    }

    // preference
    public function countryPreference()
    {
        return $this->morphedByMany(Country::class, 'job_preference');
    }

    public function jobCategoryPreference()
    {
        return $this->morphedByMany(JobCategory::class, 'job_preference');
    }

    public function industryPreference()
    {
        return $this->morphedByMany(Industry::class, 'job_preference');
    }
}
