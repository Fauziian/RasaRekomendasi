<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'vip_package_id',
        'amount',
        'payment_status',
        'payment_method',
        'payment_channel',
        'payment_gateway_log',
        'paid_at',
        'expired_at',
        'notes',
        'vip_starts_at',
        'vip_ends_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'               => 'decimal:2',
            'payment_gateway_log'  => 'array',
            'paid_at'              => 'datetime',
            'expired_at'           => 'datetime',
            'vip_starts_at'        => 'datetime',
            'vip_ends_at'          => 'datetime',
        ];
    }

    // ─── Auto-generate invoice number ──────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Transaction $transaction) {
            if (empty($transaction->invoice_number)) {
                $transaction->invoice_number = static::generateInvoiceNumber();
            }
        });

        // On successful payment, activate VIP for user
        static::updated(function (Transaction $transaction) {
            if (
                $transaction->isDirty('payment_status') &&
                $transaction->payment_status === 'success' &&
                $transaction->user &&
                $transaction->vipPackage
            ) {
                $transaction->user->activateVip($transaction->vipPackage->duration_days);
            }
        });
    }

    public static function generateInvoiceNumber(): string
    {
        $prefix = 'RR-' . date('Y') . '-';
        $last   = static::where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('invoice_number');

        $seq = $last ? (int) substr($last, strlen($prefix)) + 1 : 1;
        return $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeSuccess($query)
    {
        return $query->where('payment_status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vipPackage(): BelongsTo
    {
        return $this->belongsTo(VipPackage::class);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->payment_status) {
            'success'  => 'bg-green-100 text-green-800',
            'pending'  => 'bg-yellow-100 text-yellow-800',
            'failed'   => 'bg-red-100 text-red-800',
            'expired'  => 'bg-gray-100 text-gray-600',
            'refunded' => 'bg-blue-100 text-blue-800',
            default    => 'bg-gray-100 text-gray-600',
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
