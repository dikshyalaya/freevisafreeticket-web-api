<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkill extends Model
{
    use HasFactory;
    protected $table = 'employes_skills';

    protected $fillable = ['id', 'employ_id', 'skills_id', 'created_at', 'updated_at'];

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skills_id');
    }
}
