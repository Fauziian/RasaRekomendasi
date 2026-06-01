<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChefSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chef_schedules';

    protected $fillable = [
        'chef_id',
        'available_date',
        'available_time_start',
        'available_time_end',
        'status',
        'notes',
        'max_bookings',
        'current_bookings',
    ];

    protected function casts(): array
    {
        return [
            'available_date' => 'date',
        ];
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
            ->where('available_date', '>=', today())
            ->whereColumn('current_bookings', '<', 'max_bookings');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('available_date', '>=', today())
            ->orderBy('available_date')
            ->orderBy('available_time_start');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    public function isFullyBooked(): bool
    {
        return $this->current_bookings >= $this->max_bookings;
    }

    public function incrementBooking(): void
    {
        $this->increment('current_bookings');

        if ($this->isFullyBooked()) {
            $this->update(['status' => 'booked']);
        }
    }

    public function decrementBooking(): void
    {
        if ($this->current_bookings > 0) {
            $this->decrement('current_bookings');
            if ($this->status === 'booked') {
                $this->update(['status' => 'available']);
            }
        }
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function chef(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chef_id');
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'schedule_id');
    }

    // ─── Accessor ──────────────────────────────────────────────────────────────

    public function getTimeRangeAttribute(): string
    {
        return substr($this->available_time_start, 0, 5) . ' - ' . substr($this->available_time_end, 0, 5);
    }
}
