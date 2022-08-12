<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceLevel extends Model
{
    use HasFactory;

    protected $table = 'experiencelevels';

    protected $fillable = ['id', 'title', 'is_active', 'sort_order', 'created_at', 'updated_at'];
}
