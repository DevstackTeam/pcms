<?php

namespace App\Services;

use App\Models\Designation;
use Illuminate\Support\Facades\DB;

class DesignationService
{
    public function create(array $data): Designation
    {
        return DB::transaction(function () use ($data) {
            $data['user_id'] = auth()->id();
            return Designation::create($data);
        });
    }

    public function update(Designation $designation, array $data): Designation
    {
        return DB::transaction(function () use ($designation, $data) {
            $designation->update($data);
            return $designation;
        });
    }

    public function delete(Designation $designation): void
    {
        DB::transaction(fn () => $designation->delete());
    }
}

