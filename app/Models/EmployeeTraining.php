<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTraining extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'training_id'];

    public function employee()
    {
        return $this->belongsTo(Employe::class, 'employee_id');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }
}
