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
        return response()->json(['message' => 'Hello World']);
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
