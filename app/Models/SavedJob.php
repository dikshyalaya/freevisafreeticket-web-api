<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    use HasFactory;

    protected $fillable = ['employ_id', 'job_id'];

    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id', 'id');
    }

    public function employ()
    {
        return $this->belongsTo('App\Models\Employe', 'employ_id', 'id');
    }
}
