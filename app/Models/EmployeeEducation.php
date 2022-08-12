<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
    use HasFactory;
    protected $table = 'employes_education';

    protected $fillable = ['id', 'employ_id', 'educationlevels_id', 'created_at', 'updated_at'];

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'educationlevels_id');
    }
}
