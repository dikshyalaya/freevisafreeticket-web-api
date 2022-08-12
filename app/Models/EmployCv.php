<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployCv extends Model
{
    use HasFactory;
    protected $table = "employes_cv";

    protected $fillable = [
        'id', 'title', 'cv_file', 'employ_id', 'created_at', 'updated_at'
    ];
}
