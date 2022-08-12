<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugService
{
    public function generateUniqueSlug($model, $title, $column)
    {
        if (get_class($model)::whereSlug($slug = Str::slug($title))->exists()) {
            $max = get_class($model)::where($column,$title)->latest('id')->skip(1)->value('slug');
            if($max != null){
                if (is_numeric($max[-1])) {
                    return preg_replace_callback('/(\d+)$/', function ($matches) {
                        return $matches[1] + 1;
                    }, $max);
                }
                return "{$slug}-2";
            }
        }
        return $slug;
    }
}