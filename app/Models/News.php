<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    protected $table = "news";

    protected $fillable = [
        'id', 'title', 'short_description', 'body', 'html_content', 'feature_img', 'seo_title', 'seo_description', 'seo_keywords', 'slug', 'is_active', 'created_at', 'updated_at'
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($news) {
            $news->slug = $news->createSlug($news->title);
            $news->save();
        });
    }

    private function createSlug($title)
    {
        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = static::whereTitle($title)->latest('id')->skip(1)->value('slug');

            if (is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($matches) {
                    return $matches[1] + 1;
                }, $max);
            }

            return "{$slug}-2";
        }
        return $slug;
    }
}
