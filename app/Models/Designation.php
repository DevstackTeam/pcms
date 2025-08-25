<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'rate_per_day',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manpowers(): HasMany
    {
        return $this->hasMany(Manpower::class);
    }

    protected static function booted()
    {
        static::deleting(function ($designation) {
            if ($designation->isForceDeleting()) {
                $designation->manpowers()->forceDelete();
            } else {
                $designation->manpowers()->delete();
            }
        });

        static::restoring(function ($designation) {
            $designation->manpowers()->withTrashed()->restore();
        });
    }
}
