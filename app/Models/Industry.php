<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'is_active'];

    public function jobPreference()
    {
        return $this->morphOne(Employe::class, 'job_preference');
    }
}
