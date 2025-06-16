<?php

namespace App\Models;

use App\Enums\ProjectStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'client',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scenarios(): HasMany
    {
        return $this->hasMany(Scenario::class);
    }

    protected $enumCasts = [
        'status' => ProjectStatusEnum::class,
    ];
}
