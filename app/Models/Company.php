<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory, Notifiable;
    public $timestamps = true;
    protected $fillable = [
        'company_name', 'company_logo', 'company_cover', 'company_banner', 'user_id', 'company_phone', 'company_email', 
        'industry_id', 'company_details', 'country_id', 'city_id', 'state_id', 'company_address', 'is_active', 'is_featured',
        'updated_at', 'company_website', 'company_fb_page', 'ownership', 'no_of_employee', 'operating_since', 'company_services',
        'isocode1', 'dialcode1', 'mobile_phone1', 'isocode2', 'dialcode2', 'mobile_phone2', 'html_content_intro', 
        'html_content_service'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }

    public function company_contact_person()
    {
        return $this->hasOne("App\Models\CompanyContactPerson", "company_id", "id");
    }

    public function jobs()
    {
        return $this->hasMany("App\Models\Job", "company_id", "id");
    }

    public function job_applications()
    {
        return $this->hasManyThrough(JobApplication::class, Job::class);
    }

    public function employe()
    {
        return $this->job_applications->employe();
    }

    public function followers()
    {
        return $this->hasMany(CompanyFollower::class, "company_id", "id");
    }


    // protected $fillable = [
    //     'company_name', 'company_logo', 'company_cover', 'company_banner', 'user_id', 'company_phone', 'company_email', 
    //     'industry_id', 'company_details', 'country_id', 'city_id', 'state_id', 'company_address', 'is_active', 'is_featured',
    //     'updated_at', 'company_website', 'company_fb_page', 'ownership', 'no_of_employee', 'operating_since', 'company_services',
    //     'isocode1', 'dialcode1', 'mobile_phone1', 'isocode2', 'dialcode2', 'mobile_phone2', 'html_content_intro', 
    //     'html_content_service'

    // ];

    public function calculateProfileCompletion()
    {
        $completed = 0;
        $profileElements = ['company_name', 'company_logo', 'company_cover', 'company_phone', 'company_email', 'industry_id', 'company_details', 'operating_since', 'country_id', 'state_id',
        'company_website', 'company_fb_page', 'company_services'];
        $total = count($profileElements);

        foreach($profileElements as $element){
            $completed += empty($this->{$element}) ? 0 : 1;
        }
        if($this->company_contact_person()->count() > 0){
            $completed++;
        }

        $total = $total + 1;
        $completed = ($completed / $total) * 100;

        return round($completed, 0);
    }

}
