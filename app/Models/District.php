<?php

namespace App\Models;

// Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relationships

    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class);
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Eatery::class);
    }
}
