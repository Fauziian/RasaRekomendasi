<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'preferred_category_ids',
        'allergies',
        'available_ingredients',
        'cooking_time_limit',
        'preferred_difficulty',
        'calorie_limit',
    ];

    protected function casts(): array
    {
        return [
            'preferred_category_ids' => 'array',
            'allergies'              => 'array',
            'available_ingredients'  => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if an allergen is in the user's restriction list.
     */
    public function hasAllergyTo(string $allergen): bool
    {
        return in_array(strtolower($allergen), array_map('strtolower', $this->allergies ?? []));
    }
}
