<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvData extends Model
{
    protected $fillable = [
        'user_id',
        'personal_name',
        'personal_last_education',
        'personal_organization_history',
        'personal_achievement_history',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

