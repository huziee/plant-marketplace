<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantProblemTreatment extends Model
{
    use HasFactory;

    protected $fillable = ['plant_problem_id', 'title', 'instruction', 'sort_order'];
}
