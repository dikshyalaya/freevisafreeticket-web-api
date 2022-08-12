<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;
use App\Models\EmployJobPreference;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'functional_area', 'image_url', 'is_default', 'is_active', 'sort_order', 'lang', 'created_at', 'updated_at'];

    public function jobs()
    {
        return $this->hasMany(Job::class, "job_categories_id");
    }

//    public function job_preference()
//    {
//        return $this->belongsTo(EmployJobPreference::class, "job_category_id");
//    }

    public function jobsCount()
    {
        return $this->jobs()->count();
    }

    public function jobPreference()
    {
        return $this->morphOne(Employe::class, 'job_preference');
    }
}
