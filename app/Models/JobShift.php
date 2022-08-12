<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobShift extends Model
{
    use HasFactory;

    protected $table = 'job_shifts';

    protected $fillable = ['id', 'job_shift', 'is_default', 'is_active', 'sort_order', 'lang', 'created_at', 'updated_at'];
}
