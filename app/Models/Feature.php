<?php

namespace App\Models;

// Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relationships

    public function eateries(): BelongsToMany
    {
        return $this->belongsToMany(Eatery::class, 'eatery_feature');
    }
}
