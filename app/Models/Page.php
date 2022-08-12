<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable =['id', 'html_content',
    'title', 'body', 'seo_title', 'seo_description', 'seo_keywords', 'slug','updated_at', 'created_at'
    ];
}
