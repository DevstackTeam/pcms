<?php

namespace App\Services;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    public function store(array $data): Designation
    {
        $designation = Designation::create([
            'name' => $data['name'],
            'rate_per_day' => $data['rate_per_day'],
            'user_id' => Auth::user()->id,
        ]);
        return $designation;
    }

    public function update(Designation $designation, array $data): Designation
    {
        $designation->update([
            'name' => $data['name'],
            'rate_per_day' => $data['rate_per_day'],
        ]);
        return $designation;
    }

    public function delete(Designation $designation): void
    {
        $designation->delete();
    }
}

