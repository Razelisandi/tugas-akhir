<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'minat',
        'kemampuan',
        'rekomendasi',
        'jobs',
    ];

    protected $casts = [
        'jobs' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
