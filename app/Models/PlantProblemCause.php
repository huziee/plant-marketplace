<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantProblemCause extends Model
{
    use HasFactory;

    protected $fillable = ['plant_problem_id', 'cause', 'description', 'sort_order'];
}
