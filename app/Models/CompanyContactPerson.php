<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyContactPerson extends Model
{
    use HasFactory;
    protected $table = 'company_contact_persons';
    protected $fillable = ['name', 'email', 'phone', 'position', 'company_id', 'avatar','updated_at', 'person_designation', 'isocode', 'dialcode'];
}
