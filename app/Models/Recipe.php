<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'chef_id',
        'category_id',
        'title',
        'slug',
        'description',
        'ingredients',
        'cooking_steps',
        'prep_time',
        'cook_time',
        'difficulty',
        'calories',
        'servings',
        'image',
        'video_url',
        'is_vip_content',
        'allergens',
        'status',
        'rating_avg',
        'rating_count',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'ingredients'    => 'array',
            'cooking_steps'  => 'array',
            'allergens'      => 'array',
            'is_vip_content' => 'boolean',
            'rating_avg'     => 'decimal:2',
        ];
    }

    // ─── Auto-generate slug ────────────────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Recipe $recipe) {
            if (empty($recipe->slug)) {
                $recipe->slug = static::generateUniqueSlug($recipe->title);
            }
        });

        static::updating(function (Recipe $recipe) {
            if ($recipe->isDirty('title') && empty($recipe->slug)) {
                $recipe->slug = static::generateUniqueSlug($recipe->title);
            }
        });
    }

    public static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/recipe-placeholder.jpg');
    }

    public function getTotalTimeAttribute(): int
    {
        return $this->prep_time + $this->cook_time;
    }

    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'easy'   => 'Mudah',
            'medium' => 'Sedang',
            'hard'   => 'Sulit',
            default  => 'Sedang',
        };
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFreeContent($query)
    {
        return $query->where('is_vip_content', false);
    }

    public function scopeVipContent($query)
    {
        return $query->where('is_vip_content', true);
    }

    public function scopePopular($query)
    {
        return $query->orderByDesc('rating_avg')->orderByDesc('rating_count');
    }

    public function scopeByDifficulty($query, string $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function scopeWithinTime($query, int $maxMinutes)
    {
        return $query->whereRaw('(prep_time + cook_time) <= ?', [$maxMinutes]);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function chef(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chef_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function commentsRatings(): HasMany
    {
        return $this->hasMany(CommentRating::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(CommentRating::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(CommentRating::class)->where('is_approved', true);
    }

    public function saves(): HasMany
    {
        return $this->hasMany(RecipeSave::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipe_tag');
    }

    // ─── Rating Aggregation ────────────────────────────────────────────────────

    /**
     * Recalculate and persist rating_avg and rating_count.
     * Called via CommentRating observer.
     */
    public function recalculateRating(): void
    {
        $aggregate = $this->commentsRatings()
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
            ->first();

        $this->update([
            'rating_avg'   => round($aggregate->avg_rating ?? 0, 2),
            'rating_count' => $aggregate->total ?? 0,
        ]);
    }
}
