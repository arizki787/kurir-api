<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourierRequest;
use App\Http\Requests\UpdateCourierRequest;
use App\Http\Resources\CourierResource;
use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $query = Courier::query();

        if ($request->filled('search')) {
            $terms = explode(' ', trim($request->input('search')));
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where('name', 'like', "%{$term}%");
                }
            });
        }

        if ($request->filled('level')) {
            $levels = array_map('intval', explode(',', $request->input('level')));
            $query->whereIn('level', $levels);
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortMap = ['name' => 'name', 'joined_at' => 'joined_at'];
        $query->orderBy($sortMap[$sortBy] ?? 'name', $request->input('sort_dir', 'asc'));

        return CourierResource::collection(
            $query->paginate($request->input('per_page', 15))
        );
    }

    public function show(Courier $courier)
    {
        return new CourierResource($courier);
    }

    public function store(StoreCourierRequest $request)
    {
        $courier = Courier::create($request->validated());
        return (new CourierResource($courier))->response()->setStatusCode(201);
    }

    public function update(UpdateCourierRequest $request, Courier $courier)
    {
        $courier->update($request->validated());
        return new CourierResource($courier);
    }

    public function destroy(Courier $courier)
    {
        $courier->delete();
        return response()->json(null, 204);
    }
}
