<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployesCountry extends Model
{
    use HasFactory;
    protected $table = "employes_country";

    protected $fillable = [
        'id', 'employ_id', 'country_id', 'order_by', 'created_at', 'updated_at'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
