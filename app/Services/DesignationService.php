<?php

namespace App\Services;

use App\Models\Designation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class DesignationService
{
public function getFilteredDesignations(?string $search)
{
    return Designation::query()
        ->when($search, fn ($query) =>
            $query->where('name', 'like', '%' . $search . '%')
        )
        ->orderBy('created_at', 'desc')
        ->paginate(5)
        ->appends(request()->query());
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

