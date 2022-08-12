<?php

namespace App\Models;

use App\Models\EmployJobPreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'iso3', 'numeric_code', 'iso2', 'phonecode', 'capital', 'currency', 'currency_name',
        'currency_symbol', 'tld', 'native', 'region', 'subregion', 'timezones', 'translations', 'latitude', 'longitude', 'emoji',
        'emojiU', 'is_active',
    ];

//    public function job_preference()
//    {
//        return $this->belongsTo(EmployJobPreference::class, "country_id");
//    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'country_id');
    }

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'country_id');
    }

    public function jobPreference()
    {
        return $this->morphOne(Employe::class, 'job_preference');
    }
}
