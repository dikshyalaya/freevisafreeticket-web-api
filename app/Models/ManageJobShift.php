<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageJobShift extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'job_id', 'job_shifts_id', 'created_at', 'updated_at'];
}
