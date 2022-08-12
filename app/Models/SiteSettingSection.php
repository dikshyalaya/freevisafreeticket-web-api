<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettingSection extends Model
{
    use HasFactory;

    protected $table = 'site_setting_sections';

    protected $fillable = ['id', 'name', 'short_order', 'created_at', 'updated_at'];
}
