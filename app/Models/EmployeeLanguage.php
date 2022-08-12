<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLanguage extends Model
{
    use HasFactory;
    protected $table = 'employes_languages';

    protected $fillable = ['id','employ_id', 'language_id', 'language_level', 'created_at', 'updated_at'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
