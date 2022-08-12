<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageNewsCategory extends Model
{
    use HasFactory;

    protected $table = 'manage_news_categories';

    protected $fillable = ['id', 'news_id', 'category_id', 'created_at', 'updated_at'];
}
