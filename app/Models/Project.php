<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'client',
        'status',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scenarios(): HasMany
    {
        return $this->hasMany(Scenario::class);
    }

    protected static function booted()
    {
        static::deleting(function ($project) {
            if ($project->isForceDeleting()) {
                $project->scenarios()->forceDelete();
            } else {
                $project->scenarios()->delete();
            }
        });

        static::restoring(function ($project) {
            $project->scenarios()->withTrashed()->restore();
        });
    }
}
