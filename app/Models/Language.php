<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'lang', 'native', 'iso_code', 'is_active', 'is_default', 'created_at', 'updated_at'];
}
