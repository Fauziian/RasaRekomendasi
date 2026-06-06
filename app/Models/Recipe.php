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

        static::saved(function (Recipe $recipe) {
            $isNewPublished = $recipe->wasRecentlyCreated && $recipe->status === 'published';
            $isStatusChangedToPublished = $recipe->wasChanged('status') && $recipe->status === 'published';

            if ($isNewPublished || $isStatusChangedToPublished) {
                $users = \App\Models\User::where('role', 'user')->get();
                $chefName = $recipe->chef ? $recipe->chef->name : 'Chef';
                
                $notificationData = [];
                foreach ($users as $user) {
                    $notificationData[] = [
                        'user_id' => $user->id,
                        'title' => 'Resep Baru Dirilis!',
                        'message' => "Chef {$chefName} memposting resep baru: \"{$recipe->title}\".",
                        'link' => route('recipes.show', $recipe->slug),
                        'is_read' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                
                if (count($notificationData) > 0) {
                    \App\Models\Notification::insert($notificationData);
                }
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

        $title = strtolower($this->title);

        if (str_contains($title, 'rendang') && str_contains($title, 'panggang')) {
            return 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&q=80'; // Grilled roasted beef ribs
        }
        if (str_contains($title, 'rendang')) {
            return 'https://images.unsplash.com/photo-1606491956689-2ea866880c84?w=600&q=80'; // Indonesian beef rendang/curry
        }
        if (str_contains($title, 'nasi goreng')) {
            return 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600&q=80'; // Asian fried rice
        }
        if (str_contains($title, 'ramen')) {
            return 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=600&q=80'; // Japanese ramen bowl
        }
        if (str_contains($title, 'udang')) {
            return 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&q=80'; // Red curry shrimp style
        }
        if (str_contains($title, 'lapis legit')) {
            return 'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?w=600&q=80'; // Premium gourmet layered cake
        }
        if (str_contains($title, 'smoothie')) {
            return 'https://images.unsplash.com/photo-1490474418585-ba9bad8fd0ea?w=600&q=80'; // Fruit smoothie bowl
        }

        return 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80'; // Salad bowl default
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
            ->where('is_approved', true)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
            ->first();

        $this->update([
            'rating_avg'   => round($aggregate->avg_rating ?? 0, 2),
            'rating_count' => $aggregate->total ?? 0,
        ]);
    }
}
