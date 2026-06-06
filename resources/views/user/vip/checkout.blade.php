@extends('layouts.app')
@section('title', 'Pembayaran Paket VIP - RasaRekomendasi')

@push('styles')
<style>
    /* ─── Page Shell ─────────────────────────────────────── */
    .checkout-page {
        background: #FAF8F5;
        min-height: 100vh;
        padding: 36px 20px 80px;
    }
    .checkout-wrap {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ─── Back + Title ───────────────────────────────────── */
    .checkout-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #A03010;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        margin-bottom: 24px;
        transition: opacity .2s;
    }
    .checkout-back:hover { opacity: .75; }

    .checkout-title {
        font-size: 34px;
        font-weight: 800;
        color: #A03010;
        font-family: 'Outfit', sans-serif;
        margin: 0 0 4px;
    }
    .checkout-subtitle {
        font-size: 13px;
        color: #777;
        margin: 0 0 32px;
    }

    /* ─── Two-column layout ──────────────────────────────── */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 28px;
        align-items: start;
    }

    /* ─── Card shell ─────────────────────────────────────── */
    .co-card {
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 20px;
        padding: 28px;
    }

    /* ─── Package info ───────────────────────────────────── */
    .pkg-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
    }
    .pkg-name {
        font-size: 18px;
        font-weight: 800;
        color: #111;
        margin: 0 0 4px;
    }
    .pkg-duration {
        font-size: 12px;
        color: #777;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .pkg-badge-best {
        background: #2E7D32;
        color: #FFF;
        font-size: 10px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* ─── Invoice Code box ───────────────────────────────── */
    .invoice-box {
        background: #FFF9F0;
        border: 1.5px solid #FFE5CA;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .invoice-sparkle {
        width: 40px;
        height: 40px;
        background: #FFF0DC;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #E68A00;
        flex-shrink: 0;
    }
    .invoice-label {
        font-size: 10px;
        font-weight: 700;
        color: #E68A00;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 4px;
    }
    .invoice-code {
        font-family: 'Courier New', monospace;
        font-size: 16px;
        font-weight: 800;
        color: #333;
        letter-spacing: 1px;
    }

    /* ─── Section heading ────────────────────────────────── */
    .section-heading {
        font-size: 15px;
        font-weight: 800;
        color: #111;
        margin: 28px 0 16px;
    }

    /* ─── Payment option cards ───────────────────────────── */
    .payment-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .pay-opt {
        position: relative;
        border: 1.5px solid #EAE6DF;
        border-radius: 14px;
        padding: 16px 16px 16px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        background: #FFF;
        transition: border-color .2s, background .2s, box-shadow .2s;
        user-select: none;
    }
    .pay-opt:hover {
        border-color: #FFBFAD;
        background: #FFF8F6;
    }
    .pay-opt.selected {
        border-color: #A03010;
        background: #FFF4F1;
        box-shadow: 0 0 0 3px rgba(160,48,16,.08);
    }

    /* Hidden native radio */
    .pay-opt input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* Icon circle */
    .pay-icon-wrap {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #F5F5F5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #555;
        flex-shrink: 0;
        transition: background .2s, color .2s;
    }
    .pay-opt.selected .pay-icon-wrap {
        background: #FFE8E0;
        color: #A03010;
    }

    /* Text */
    .pay-text { flex: 1; min-width: 0; }
    .pay-name {
        font-size: 13px;
        font-weight: 700;
        color: #111;
        margin: 0 0 2px;
        line-height: 1.3;
    }
    .pay-sub {
        font-size: 11px;
        color: #888;
        line-height: 1.3;
    }

    /* Checkmark badge */
    .pay-check {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #A03010;
        color: #FFF;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        flex-shrink: 0;
    }
    .pay-opt.selected .pay-check { display: flex; }

    /* ─── Summary sidebar ────────────────────────────────── */
    .summary-card {
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 20px;
        padding: 26px;
        position: sticky;
        top: 90px;
    }
    .sum-title {
        font-size: 13px;
        font-weight: 800;
        color: #999;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 20px;
    }
    .sum-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin-bottom: 12px;
    }
    .sum-label { color: #666; }
    .sum-value { font-weight: 600; color: #333; }
    .sum-row.discount .sum-value { color: #2E7D32; font-weight: 700; }
    .sum-divider { border: none; border-top: 1px solid #EEE; margin: 14px 0; }

    .sum-total-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 4px;
    }
    .sum-total-label {
        font-size: 12px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        line-height: 1.6;
    }
    .sum-total-amount {
        font-size: 28px;
        font-weight: 800;
        color: #A03010;
        line-height: 1;
    }
    .sum-currency {
        font-size: 16px;
        font-weight: 800;
        color: #A03010;
        display: block;
    }

    .pay-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #D94E20, #A03010);
        color: #FFF;
        border: none;
        border-radius: 14px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 22px;
        transition: opacity .2s, transform .15s;
        letter-spacing: .3px;
    }
    .pay-btn:hover { opacity: .92; transform: translateY(-1px); }
    .pay-btn:active { transform: translateY(0); }

    .sum-secure {
        font-size: 11px;
        color: #AAA;
        text-align: center;
        margin-top: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    /* ─── Responsive ─────────────────────────────────────── */
    @media (max-width: 900px) {
        .checkout-grid { grid-template-columns: 1fr; }
        .summary-card { position: static; }
    }
    @media (max-width: 560px) {
        .payment-grid { grid-template-columns: 1fr; }
        .checkout-title { font-size: 26px; }
    }
</style>
@endpush

@section('content')
<div class="checkout-page">
<div class="checkout-wrap">

    {{-- Back & heading --}}
    <a href="{{ route('vip.index') }}" class="checkout-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Paket
    </a>
    <h1 class="checkout-title">Checkout VIP</h1>
    <p class="checkout-subtitle">Complete your payment to unlock exclusive kitchen secrets.</p>

    @php
        $generatedInvoice = 'RR-VIP-' . date('Y') . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    @endphp

    <form method="POST" action="{{ route('vip.checkout.process', $package) }}" id="checkoutForm">
    @csrf
    <input type="hidden" name="invoice_number" value="{{ $generatedInvoice }}">
    <div class="checkout-grid">

        {{-- ── LEFT column ───────────────────────────── --}}
        <div>
            {{-- Package card --}}
            <div class="co-card">
                <div class="pkg-row">
                    <div>
                        <p class="pkg-name">{{ $package->name }}</p>
                        <div class="pkg-duration">
                            <i class="far fa-clock"></i>
                            Duration: {{ $package->duration_days }} Days
                            @if($package->duration_days == 7) (Weekly Plan)
                            @elseif($package->duration_days == 30) (Monthly Plan)
                            @elseif($package->duration_days == 90) (3 Month Plan)
                            @elseif($package->duration_days == 365) (Annual Plan)
                            @else ({{ $package->duration_label ?? 'Custom Plan' }})
                            @endif
                        </div>
                    </div>
                    @php
                        $badgeText = 'BEST VALUE';
                        if($package->price == 49000) $badgeText = 'COBA DULU';
                        elseif($package->price == 129000) $badgeText = 'TERBARU';
                        elseif($package->price == 299000) $badgeText = 'HEMAT 30%';
                    @endphp
                    <span class="pkg-badge-best">{{ $badgeText }}</span>
                </div>

                {{-- Invoice code --}}
                <div class="invoice-box">
                    <div class="invoice-sparkle">
                        <i class="fas fa-sparkles"></i>
                    </div>
                    <div>
                        <div class="invoice-label">Invoice Code</div>
                        <div class="invoice-code">{{ $generatedInvoice }}</div>
                    </div>
                </div>
            </div>

            {{-- Payment Methods --}}
            <p class="section-heading">Select Payment Method</p>
            <div class="payment-grid" id="paymentGrid">

                {{-- E-Wallet --}}
                <label class="pay-opt selected" onclick="selectPay(this, 'e_wallet')">
                    <input type="radio" name="payment_method" value="e_wallet" checked>
                    <div class="pay-icon-wrap">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="pay-text">
                        <p class="pay-name">E-Wallet<br>(OVO/Gopay)</p>
                        <span class="pay-sub">Instant Confirmation</span>
                    </div>
                    <div class="pay-check"><i class="fas fa-check"></i></div>
                </label>

                {{-- Bank Transfer --}}
                <label class="pay-opt" onclick="selectPay(this, 'bank_transfer')">
                    <input type="radio" name="payment_method" value="bank_transfer">
                    <div class="pay-icon-wrap">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="pay-text">
                        <p class="pay-name">Bank Transfer (VA)</p>
                        <span class="pay-sub">BCA, Mandiri, BNI</span>
                    </div>
                    <div class="pay-check"><i class="fas fa-check"></i></div>
                </label>

                {{-- Credit Card --}}
                <label class="pay-opt" onclick="selectPay(this, 'credit_card')">
                    <input type="radio" name="payment_method" value="credit_card">
                    <div class="pay-icon-wrap">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="pay-text">
                        <p class="pay-name">Credit Card</p>
                        <span class="pay-sub">Visa, Mastercard, JCB</span>
                    </div>
                    <div class="pay-check"><i class="fas fa-check"></i></div>
                </label>

                {{-- QRIS --}}
                <label class="pay-opt" onclick="selectPay(this, 'qris')">
                    <input type="radio" name="payment_method" value="qris">
                    <div class="pay-icon-wrap">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="pay-text">
                        <p class="pay-name">QRIS</p>
                        <span class="pay-sub">Pay with any app</span>
                    </div>
                    <div class="pay-check"><i class="fas fa-check"></i></div>
                </label>
            </div>
        </div>

        {{-- ── RIGHT column: summary ─────────────────── --}}
        <div class="summary-card">
            <div class="sum-title">Payment Details</div>

            <div class="sum-row">
                <span class="sum-label">Subtotal</span>
                <span class="sum-value">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
            </div>
            <div class="sum-row">
                <span class="sum-label">Service Fee</span>
                <span class="sum-value">Rp {{ number_format(round($package->price * 0.01), 0, ',', '.') }}</span>
            </div>
            <div class="sum-row discount">
                <span class="sum-label">Discount (Promo)</span>
                <span class="sum-value">-Rp {{ number_format(round($package->price * 0.15), 0, ',', '.') }}</span>
            </div>

            <hr class="sum-divider">

            @php
                $total = $package->price + round($package->price * 0.01) - round($package->price * 0.15);
                $totalStr = number_format($total, 0, ',', '.');
                $totalParts = explode(',', $totalStr);
            @endphp

            <div class="sum-total-row">
                <div class="sum-total-label">Total<br>Amount</div>
                <div style="text-align:right;">
                    <span class="sum-currency">Rp</span>
                    <span class="sum-total-amount">{{ $totalStr }}</span>
                </div>
            </div>

            <button type="submit" class="pay-btn">
                Bayar Sekarang &rarr;
            </button>

            <p class="sum-secure">
                <i class="fas fa-lock"></i>
                Secure 256-bit SSL Encrypted Payment
            </p>
        </div>

    </div>
    </form>

</div>
</div>
@endsection

@push('scripts')
<script>
function selectPay(clickedLabel, value) {
    // Remove selected from all
    document.querySelectorAll('.pay-opt').forEach(function(el) {
        el.classList.remove('selected');
        el.querySelector('input[type="radio"]').checked = false;
    });
    // Activate clicked
    clickedLabel.classList.add('selected');
    clickedLabel.querySelector('input[type="radio"]').checked = true;
}
</script>
@endpush
