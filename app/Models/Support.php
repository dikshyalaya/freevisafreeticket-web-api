<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = ["support_category_id", "question", "slug", "answer", "answer_html", 'view'];

    public function support_category()
    {
        return $this->belongsTo(SupportCategory::class, 'support_category_id', 'id');
    }

    public function support_types()
    {
        return $this->belongsToMany(SupportType::class, 'type_supports');
    }
}
