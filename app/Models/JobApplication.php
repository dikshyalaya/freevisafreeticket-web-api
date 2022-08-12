<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $table = "job_applications";

    protected $fillable = [
        'id', 'employ_id', 'job_id', 'status', 'created_at', 'updated_at', 'interview_status', 'interview_date', 'interview_time'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d M Y', strtotime($value));
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employ_id', 'id');
    }

    public function company()
    {
        return $this->job()->whereHas('company')->with(['company']);
    }
}
