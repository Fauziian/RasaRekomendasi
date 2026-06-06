<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentRating extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comments_ratings';

    protected $fillable = [
        'user_id',
        'recipe_id',
        'comment',
        'rating',
        'is_approved',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'rating'      => 'integer',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    // ─── Observers for rating aggregation ─────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        // After create/update/delete, recalculate recipe rating
        $recalculate = function (CommentRating $model) {
            if ($model->recipe) {
                $model->recipe->recalculateRating();
            }
        };

        static::created($recalculate);
        static::updated($recalculate);
        static::deleted($recalculate);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    // ─── Star rendering helper ─────────────────────────────────────────────────

    public function getStarsHtmlAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '★' : '☆';
        }
        return $stars;
    }
}
