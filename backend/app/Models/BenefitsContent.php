<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitsContent extends Model
{
    protected $fillable = [
        'directus_id',
        'name',
        'description',
        'eligibility_criteria',
        'content'
    ];

    protected $casts = [
        'eligibility_criteria' => 'array',
        'content' => 'array'
    ];
} 