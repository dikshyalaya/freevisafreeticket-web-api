<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulInformation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'desc', 'desc_content', 'slug', 'logo'];
}
