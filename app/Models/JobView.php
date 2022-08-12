<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobView extends Model
{
    use HasFactory;
    
    protected $fillable = ['job_id', 'fingerprint', 'useragent', 'browser', 'timezone', 'view_date', 'view_time'];
}
