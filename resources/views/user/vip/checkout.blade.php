@extends('layouts.app')
@section('title', 'Metode Pembayaran VIP')
@section('content')
<div class="page-padding" style="max-width:600px;margin:0 auto;padding-top:40px;padding-bottom:60px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('vip.index') }}" class="btn btn-white btn-sm" style="margin-bottom:15px;"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1 style="font-size:28px;font-weight:800;color:#111;">Konfirmasi Pembayaran</h1>
        <p style="color:var(--text-m);font-size:14px;margin-top:4px;">Anda akan berlangganan paket <strong>{{ $package->name }}</strong>.</p>
    </div>

    <form method="POST" action="{{ route('vip.checkout.process', $package) }}" class="card" style="padding:30px;border:none;box-shadow:var(--shadow-lg);">
        @csrf
        
        <div style="background:#FFF9EF;padding:20px;border-radius:12px;margin-bottom:24px;">
            <div style="font-size:12px;color:var(--text-m);text-transform:uppercase;">TOTAL TAGIHAN</div>
            <div style="font-size:26px;font-weight:800;color:var(--primary);margin-top:4px;">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
            <div style="font-size:11px;color:var(--text-m);margin-top:4px;">Berlaku untuk durasi {{ $package->duration_days }} hari.</div>
        </div>

        <div class="form-group" style="margin-bottom:24px;">
            <label class="form-label" style="font-size:12px;font-weight:700;">METODE PEMBAYARAN INSTAN</label>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach([
                    ['e_wallet', 'Dompet Digital (GOPAY, OVO, DANA)', 'fas fa-wallet'],
                    ['bank_transfer', 'Transfer Virtual Account Bank', 'fas fa-university'],
                    ['credit_card', 'Kartu Kredit / Visa / Mastercard', 'fas fa-credit-card']
                ] as [$value, $label, $icon])
                <label style="border:1px solid var(--border);padding:14px;border-radius:12px;display:flex;align-items:center;gap:12px;cursor:pointer;transition:all .2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                    <input type="radio" name="payment_method" value="{{ $value }}" style="accent-color:var(--primary);width:18px;height:18px;" required>
                    <i class="{{ $icon }}" style="font-size:18px;color:var(--primary);"></i>
                    <span style="font-size:13px;font-weight:600;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn" style="width:100%;justify-content:center;padding:12px;"><i class="fas fa-check-circle"></i> Bayar Sekarang</button>
    </form>
</div>
@endsection
