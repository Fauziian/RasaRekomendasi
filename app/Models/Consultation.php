<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'chef_id',
        'schedule_id',
        'status',
        'topic',
        'chef_notes',
        'started_at',
        'ended_at',
        'duration_minutes',
        'user_rating',
        'user_feedback',
    ];

    protected $casts = [
        'started_at'       => 'datetime',
        'ended_at'         => 'datetime',
        'user_rating'      => 'integer',
    ];

    // ─── Boot ──────────────────────────────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Consultation $c) {
            $c->schedule->incrementBooking();
        });

        static::updated(function (Consultation $c) {
            // If cancelled, free up the slot
            if ($c->isDirty('status') && $c->status === 'cancelled') {
                $c->schedule->decrementBooking();
            }

            // Auto-calculate duration when ended
            if ($c->isDirty('ended_at') && $c->started_at && $c->ended_at) {
                $c->duration_minutes = $c->started_at->diffInMinutes($c->ended_at);
                $c->saveQuietly();
            }
        });
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed', 'ongoing']);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chef(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chef_id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(ChefSchedule::class, 'schedule_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'ongoing'   => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default     => 'Unknown',
        };
    }
}
