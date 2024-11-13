<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revenue;
use App\Http\Resources\RevenueRessource;
use Illuminate\Support\Facades\Validator;

class RevenueController extends Controller
{
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

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'year' => 'required|integer|in:' . date('Y'),
            'month' => 'required|integer|between:1,12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Fields validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $revenue = Revenue::create([
            'id_user' => $request->id_user,
            'amount' => $request->amount,
            'year' => $request->year,
            'month' => $request->month,
        ]);

        return response()->json([
            'message' => 'Revenue added successfully',
            'data' => new RevenueRessource($revenue),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'year' => 'required|integer|in:' . date('Y'),
            'month' => 'required|integer|between:1,12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Fields validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $revenue = Revenue::find($id);

        if (!$revenue) {
            return response()->json(['message' => 'Revenue not found'], 404);
        }

        $revenue->update([
            'id_user' => $request->id_user,
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

        $revenue->delete();

        return response()->json([
            'message' => 'Revenue deleted successfully',
        ], 201);
    }
}
