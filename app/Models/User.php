<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'bio',
        'is_vip',
        'vip_expires_at',
        'specialization',
        'rating_avg',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_vip'            => 'boolean',
            'is_active'         => 'boolean',
            'vip_expires_at'    => 'datetime',
            'rating_avg'        => 'decimal:2',
        ];
    }

    // ─── Role Helpers ──────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isChef(): bool
    {
        return $this->role === 'chef';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // ─── VIP Helpers ───────────────────────────────────────────────────────────

    /**
     * Check if the user has an active, non-expired VIP membership.
     */
    public function hasActiveVip(): bool
    {
        if (! $this->is_vip) {
            return false;
        }

        if ($this->vip_expires_at === null) {
            return true; // Lifetime VIP
        }

        return $this->vip_expires_at->isFuture();
    }

    /**
     * Activate VIP for a given number of days (stacking on existing expiry).
     */
    public function activateVip(int $days): void
    {
        $baseDate = ($this->is_vip && $this->vip_expires_at?->isFuture())
            ? $this->vip_expires_at
            : Carbon::now();

        $this->update([
            'is_vip'         => true,
            'vip_expires_at' => $baseDate->addDays($days),
        ]);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    /** Recipes authored by this chef */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'chef_id');
    }

    /** User's saved/bookmarked preference profile */
    public function preference(): HasOne
    {
        return $this->hasOne(Preference::class);
    }

    /** Comments and ratings left by this user */
    public function commentsRatings(): HasMany
    {
        return $this->hasMany(CommentRating::class);
    }

    /** Transactions (VIP purchases) */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /** Recipes saved/bookmarked by this user (pivot: recipe_saves) */
    public function savedRecipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_saves', 'user_id', 'recipe_id')
                    ->withTimestamps();
    }

    /** Schedules set by this chef */
    public function schedules(): HasMany
    {
        return $this->hasMany(ChefSchedule::class, 'chef_id');
    }

    /** Consultations where the user is the CLIENT */
    public function consultationsAsUser(): HasMany
    {
        return $this->hasMany(Consultation::class, 'user_id');
    }

    /** Consultations where the user is the CHEF */
    public function consultationsAsChef(): HasMany
    {
        return $this->hasMany(Consultation::class, 'chef_id');
    }

    /** Messages sent by this user */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /** Notifications received by this user */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class)->latest();
    }

    /** Notifications visible to this user based on their role */
    public function visibleNotifications()
    {
        $query = $this->notifications();
        if ($this->isUser()) {
            $query->where('title', 'Resep Baru Dirilis!');
        }
        return $query;
    }

    public function getFormattedNameAttribute(): string
    {
        if ($this->role === 'chef') {
            return str_starts_with($this->name, 'Chef') ? $this->name : 'Chef ' . $this->name;
        }
        return $this->name;
    }

    // ─── Avatar URL Accessor ───────────────────────────────────────────────────

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Generate initials-based avatar via UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name)
            . '&background=ac3509&color=fff&size=128&rounded=true';
    }
}
