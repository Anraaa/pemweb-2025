<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $data = Test::all();
        return response()->json([
            'message' => 'List of tests retrieved successfully.',
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }
        return response()->json([
            'message' => 'Test retrieved successfully.',
            'data' => $test,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test = Test::create($validatedData);
        return response()->json([
            'message' => 'Test created successfully.',
            'data' => $test,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update($validatedData);
        return response()->json([
            'message' => 'Test updated successfully.',
            'data' => $test,
        ]);
    }

    public function destroy($id)
    {
        $test = Test::find($id);
        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }

        $test->delete();
        return response()->json(['message' => 'Test deleted successfully.']);
    }
}