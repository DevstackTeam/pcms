<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scenario extends Model
{
    protected $fillable = [
        'project_id',
        'markup',
        'duration',
        'remark',
        'total_cost',
        'final_cost',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function manpowers(): HasMany
    {
        return $this->hasMany(Manpower::class);
    }
}
