<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Benefits extends Model
{
    protected $fillable = [
        'name',
        'description',
        'eligibility_criteria'
    ];

    public function eligibilityRules()
    {
        return $this->hasMany(EligibilityRule::class);
    }
} 