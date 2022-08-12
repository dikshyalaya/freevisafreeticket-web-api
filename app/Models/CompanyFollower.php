<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyFollower extends Model
{
    use HasFactory;

    protected $fillable = ["employ_id", "company_id", "followed_time"];

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id", "id");
    }
}
