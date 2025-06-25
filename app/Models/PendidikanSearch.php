<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_of_study',
        'education_level',
        'skills',
        'career_goals',
        'location_preference',
        'learning_style',
        'recommendation',
        'top_universities',
    ];

    protected $casts = [
        'top_universities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
