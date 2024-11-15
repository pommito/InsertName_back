<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controllers\Middleware;
use App\Models\Revenue;
use App\Http\Controllers\Controller;
use App\Http\Resources\RevenueRessource;
use App\Http\Requests\RevenueRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;

class RevenueController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        $revenues = Revenue::get();

        if($revenues->isEmpty())
        {
            return response()->json(['message' => 'No revenues found'], 404);
        }

        return response()->json(RevenueRessource::collection($revenues));
    }

    public function show($id)
    {
        $revenue = Revenue::find($id);

        if (!$revenue) {
            return response()->json(['message' => 'Revenue not found'], 404);
        }

        return response()->json(new RevenueRessource($revenue));
    }

    public function store(RevenueRequest $request)
    {

        $fields = $request->validated();

        // Remove 'user_id' since it's not a column in the table
        unset($fields['user_id']);

        $revenue = $request->user()->revenues()->create($fields);

        return response()->json([
            'message' => 'Revenue added successfully',
            'data' => new RevenueRessource($revenue),
        ], 201);
    }

    public function update(RevenueRequest $request, $id)
    {
        $revenue = Revenue::find($id);

        if (!$revenue) {
            return response()->json(['message' => 'Revenue not found'], 404);
        }

        Gate::authorize('modify', $revenue);

        $revenue->update([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'year' => $request->year,
            'month' => $request->month,
        ]);

        return response()->json([
            'message' => 'Revenue updated successfully',
            'data' => new RevenueRessource($revenue),
        ], 201);
    }

    public function destroy($id)
    {
        $revenue = Revenue::find($id);

        if (!$revenue) {
            return response()->json(['message' => 'Revenue not found'], 404);
        }

        Gate::authorize('modify', $revenue);

        $revenue->delete();

        return response()->json([
            'message' => 'Revenue deleted successfully',
        ], 201);
    }
}
