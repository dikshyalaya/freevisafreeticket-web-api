<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployesJobCategory extends Model
{
    use HasFactory;
    protected $table = "employes_job_categories";

    protected $fillable = [
        'id', 'employ_id', 'job_category_id', 'order_by', 'created_at', 'updated_at'
    ];
}
