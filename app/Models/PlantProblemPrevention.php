<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantProblemPrevention extends Model
{
    use HasFactory;

    protected $fillable = ['plant_problem_id', 'instruction', 'sort_order'];
}
