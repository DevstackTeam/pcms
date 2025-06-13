<?php

namespace App\Services;

use App\Models\Designation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class DesignationService
{
public function getFilteredDesignations(array $filters): LengthAwarePaginator
{
    return Designation::query()
        ->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(10)
        ->withQueryString();
}
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

