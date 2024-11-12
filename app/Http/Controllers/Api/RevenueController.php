<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Revenue;
use App\Http\Resources\RevenueResource;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index()
    {
        $revenues = Revenue::get();

        if($revenues->isEmpty())
        {
            return response()->json(['message' => 'No revenues found'], 404);
        }

        return response()->json(RevenueResource::collection($revenues));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'year' => 'required|integer|in:' . date('Y'),
            'month' => 'required|integer|between:1,12',
        ]);

        $revenue = Revenue::create([
            'id_user' => $request->id_user,
            'amount' => $request->amount,
            'year' => $request->year,
            'month' => $request->month,
        ]);

        return response()->json([
            'message' => 'Revenue added successfully',
            'data' => new RevenueResource($revenue),
        ], 201);
    }

    public function show($id)
    {
        return response()->json(['message' => 'Hello World']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Hello World']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Hello World']);
    }
}
