<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExperience extends Model
{
    use HasFactory;
    protected $table = 'employes_experience';

    protected $fillable = ['id', 'employ_id', 'experiencelevels_id', 'created_at', 'updated_at', 'country_id', 'job_category_id', 'industry_id', 'working_year', 'working_month'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function job_category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

//    public function job()
//    {
//        return $this->belongsTo(Job::class, 'job_title_id'); //Currently Do not remove this relation
//    }
}
