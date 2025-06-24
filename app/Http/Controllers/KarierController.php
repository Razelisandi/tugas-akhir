<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CareerSearch;

class KarierController extends Controller
{
    public function index()
    {
        return view('karier');
    }

    public function saveSearch(Request $request)
    {
        $request->validate([
            'minat' => 'required|string|max:255',
            'kemampuan' => 'required|string|max:255',
            'rekomendasi' => 'required|string|max:255',
            'jobs' => 'nullable|array',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        $careerSearch = CareerSearch::create([
            'user_id' => $userId,
            'minat' => $request->minat,
            'kemampuan' => $request->kemampuan,
            'rekomendasi' => $request->rekomendasi,
            'jobs' => $request->jobs,
        ]);

        return response()->json(['message' => 'Search saved successfully', 'data' => $careerSearch]);
    }

    public function getHistory()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        $history = CareerSearch::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        \Log::info('CareerSearch history for user '.$userId.': '.json_encode($history));

        return response()->json(['data' => $history]);
    }

    public function deleteSearch($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        $careerSearch = CareerSearch::where('id', $id)->where('user_id', $userId)->first();

        if (!$careerSearch) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $careerSearch->delete();

        return response()->json(['message' => 'Search deleted successfully']);
    }
}
