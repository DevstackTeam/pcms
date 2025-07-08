<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scenario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'markup',
        'duration',
        'remark',
        'total_cost',
        'final_cost',
    ];

    protected $casts = [
        'total_cost' => 'float',
        'final_cost' => 'float',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function manpowers(): HasMany
    {
        return $this->hasMany(Manpower::class);
    }

    protected static function booted()
    {
        static::deleting(function ($scenario) {
            if ($scenario->isForceDeleting()) {
                $scenario->manpowers()->forceDelete();
            } else {
                $scenario->manpowers()->delete();
            }
        });

        static::restoring(function ($scenario) {
            $scenario->manpowers()->withTrashed()->restore();
        });
    }
}
