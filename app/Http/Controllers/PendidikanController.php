<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PendidikanSearch;

class PendidikanController extends Controller
{
    public function index()
    {
        return view('pendidikan');
    }

    public function saveSearch(Request $request)
    {
        $request->validate([
            'field_of_study' => 'required|string|max:255',
            'education_level' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'career_goals' => 'required|string|max:255',
            'location_preference' => 'required|string|max:255',
            'learning_style' => 'required|string|max:255',
            'recommendation' => 'required|string|max:255',
            'top_universities' => 'nullable|array',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        $pendidikanSearch = PendidikanSearch::create([
            'user_id' => $userId,
            'field_of_study' => $request->field_of_study,
            'education_level' => $request->education_level,
            'skills' => $request->skills,
            'career_goals' => $request->career_goals,
            'location_preference' => $request->location_preference,
            'learning_style' => $request->learning_style,
            'recommendation' => $request->recommendation,
            'top_universities' => $request->top_universities,
        ]);

        return response()->json(['message' => 'Search saved successfully', 'data' => $pendidikanSearch]);
    }

    public function getHistory()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        $history = PendidikanSearch::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        \Log::info('PendidikanSearch history for user '.$userId.': '.json_encode($history));

        return response()->json(['data' => $history]);
    }

    public function deleteSearch($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        $pendidikanSearch = PendidikanSearch::where('id', $id)->where('user_id', $userId)->first();

        if (!$pendidikanSearch) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $pendidikanSearch->delete();

        return response()->json(['message' => 'Search deleted successfully']);
    }
}
