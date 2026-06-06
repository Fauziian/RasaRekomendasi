@extends('layouts.app')
@section('title', 'Pembayaran Sukses - RasaRekomendasi')

@push('styles')
<style>
    .success-page {
        background: radial-gradient(circle at 80% 20%, #F0FFF4 0%, #FAF8F5 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    .success-card {
        width: 100%;
        max-width: 550px;
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
        padding: 40px 32px;
        text-align: center;
    }

    /* CSS Success Checkmark Animation */
    .success-icon-wrap {
        width: 100px;
        height: 100px;
        background: #E8F5E9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        position: relative;
    }
    .checkmark-circle {
        width: 80px;
        height: 80px;
        background: #2E7D32;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .checkmark-icon {
        color: #FFF;
        font-size: 40px;
        animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
    }

    .success-title {
        font-size: 28px;
        font-weight: 800;
        color: #2E7D32;
        margin-bottom: 8px;
        font-family: 'Outfit', sans-serif;
    }
    .success-subtitle {
        font-size: 15px;
        color: #555;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .details-box {
        background: #FAF8F5;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 32px;
        text-align: left;
    }
    .details-title {
        font-size: 12px;
        font-weight: 800;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 14px;
        border-bottom: 1px solid #EAE6DF;
        padding-bottom: 8px;
    }
    .details-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        padding: 6px 0;
    }
    .details-label { color: #666; }
    .details-val { font-weight: 700; color: #111; }

    /* Benefit button triggers */
    .benefit-btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #FF5A36;
        color: #FFF;
        padding: 14px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        margin-bottom: 12px;
        transition: background .2s, transform .15s;
        box-shadow: 0 6px 20px rgba(255,90,54,.2);
    }
    .benefit-btn-primary:hover {
        background: #E04D2C;
        transform: translateY(-2px);
    }

    .benefit-btn-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #FFF;
        color: #333;
        border: 1.5px solid #EAE6DF;
        padding: 13px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s, border-color .2s;
    }
    .benefit-btn-secondary:hover {
        background: #FAF8F5;
        border-color: #C8C2B8;
    }

    @keyframes scaleIn {
        0% { transform: scale(0); }
        100% { transform: scale(1); }
    }
</style>
@endpush

@section('content')
<div class="success-page">
    <div class="success-card">
        <div class="success-icon-wrap">
            <div class="checkmark-circle">
                <i class="fas fa-check checkmark-icon"></i>
            </div>
        </div>

        <h1 class="success-title">Pembayaran Sukses!</h1>
        <p class="success-subtitle">
            Selamat! Transaksi Anda telah berhasil diverifikasi oleh sistem. Akun Anda kini aktif sebagai <strong>VIP Member</strong>.
        </p>

        <div class="details-box">
            <div class="details-title">Detail Aktivasi VIP</div>
            <div class="details-row">
                <span class="details-label">Invoice</span>
                <span class="details-val">{{ $transaction->invoice_number }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Paket</span>
                <span class="details-val">{{ $transaction->vipPackage->name }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Status Akun</span>
                <span class="details-val" style="color: #2E7D32;"><i class="fas fa-crown"></i> VIP Aktif</span>
            </div>
            <div class="details-row">
                <span class="details-label">Masa Berlaku VIP</span>
                <span class="details-val" style="color: var(--primary);">
                    {{ $transaction->vip_ends_at ? $transaction->vip_ends_at->format('d M Y, H:i') : now()->addYear()->format('d M Y, H:i') }} WIB
                </span>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:8px; align-items: center; justify-content: center; width: 100%;">
            <a href="{{ route('recipes.index') }}" class="benefit-btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; max-width: 320px; text-align: center; margin: 0 auto;">
                <i class="fas fa-utensils"></i> Jelajahi Resep VIP
            </a>
            <a href="{{ route('consultations.index') }}" class="benefit-btn-secondary" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; max-width: 320px; text-align: center; margin: 0 auto;">
                <i class="fas fa-comments"></i> Hubungi Chef Privat Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
