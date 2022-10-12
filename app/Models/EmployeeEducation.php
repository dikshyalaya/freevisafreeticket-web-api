<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
    use HasFactory;
    protected $table = 'employes_education';

    protected $fillable = ['id', 'employ_id', 'educationlevels_id', "institution_name", "institution_address", "completion_year", "score", 'created_at', 'updated_at'];

    public function _educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'educationlevels_id');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'educationlevels_id');
    }
}
