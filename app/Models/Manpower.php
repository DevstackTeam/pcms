<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manpower extends Model
{
    protected $fillable = [
        'designation_id',
        'scenario_id',
        'total_day',
        'rate_per_day',
        'no_of_people',
        'remark',
        'total_cost',
    ];

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class);
    }
}
