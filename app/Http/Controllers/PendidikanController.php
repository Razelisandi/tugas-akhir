<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    public function index()
    {
        return view('pendidikan');
    }

    public function predictEducation(Request $request)
    {
        $data = $request->only([
            'field_of_study',
            'education_level',
            'skills',
            'career_goals',
            'location_preference',
            'learning_style'
        ]);

        // TODO: Implement decision tree algorithm or call prediction service here
        // For now, return a dummy recommendation

        $recommendation = "Based on your inputs, we recommend you to consider Computer Science at XYZ University.";

        return response()->json(['recommendation' => $recommendation]);
    }
}
