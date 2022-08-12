<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'slug'];

    public function supports()
    {
        return $this->hasMany(Support::class, "support_category_id", "id");
    }
}
