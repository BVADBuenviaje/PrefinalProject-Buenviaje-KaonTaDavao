<?php

namespace App\Models;

// Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'eatery_id',
        'user_id',
        'rating',
        'body',
    ];

    // Relationships

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
