<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manpower extends Model
{
    protected $fillable = [
        'total_day',
        'rate_per_day',
        'no_of_people',
    ];

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Scenario::class);
    }
}
