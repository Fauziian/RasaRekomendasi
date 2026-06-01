@extends('layouts.app')
@section('title', 'Langganan VIP RasaRekomendasi')
@section('content')
<div class="page-padding" style="max-width:1000px;margin:0 auto;padding-top:50px;padding-bottom:60px;">
    <div style="text-align:center;margin-bottom:50px;">
        <span class="badge badge-primary" style="margin-bottom:12px;background:#FFF9C4;color:#7c5b00;"><i class="fas fa-crown"></i> Exclusive Package</span>
        <h1 style="font-size:36px;font-weight:800;color:#111;">Buka Pengalaman Kuliner Terbaik Anda</h1>
        <p style="color:var(--text-m);font-size:15px;margin-top:8px;">Bergabung dengan ribuan Gen Z Home Chefs yang memasak layaknya bintang lima dengan fitur VIP premium.</p>
    </div>

    @if(Auth::check() && Auth::user()->is_vip)
        <div class="card" style="padding:40px;text-align:center;background:linear-gradient(135deg, #FFF9C4, #FFE082);border:none;margin-bottom:40px;">
            <i class="fas fa-crown" style="font-size:48px;color:#f57f17;margin-bottom:15px;display:block;"></i>
            <h3 style="font-size:22px;font-weight:800;color:#5d4037;">Status Keanggotaan Anda: VIP Member</h3>
            <p style="color:#5d4037;font-size:14px;margin-top:8px;">Terima kasih atas langganan VIP Anda! Nikmati seluruh resep premium, video tutorial, serta konsultasi chat privat bersama Chef profesional.</p>
            <div style="margin-top:20px;display:flex;justify-content:center;gap:12px;">
                <a href="{{ route('recipes.index') }}" class="btn" style="background:#f57f17;border:none;"><i class="fas fa-utensils"></i> Jelajah Resep VIP</a>
            </div>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:24px;">
            @forelse($packages as $pkg)
            <div class="card" style="padding:30px;display:flex;flex-direction:column;position:relative;border:{{ $pkg->price > 50000 ? '2px solid var(--primary)' : '1px solid var(--border)' }};">
                @if($pkg->price > 50000)
                    <span style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--primary);color:#fff;font-size:10px;font-weight:700;padding:4px 12px;border-radius:20px;text-transform:uppercase;">Terpopuler</span>
                @endif
                <h3 style="font-size:20px;font-weight:800;margin-bottom:10px;">{{ $pkg->name }}</h3>
                <div style="font-size:28px;font-weight:800;color:var(--primary);margin-bottom:20px;">
                    Rp {{ number_format($pkg->price, 0, ',', '.') }} <span style="font-size:13px;color:var(--text-m);font-weight:500;">/ {{ $pkg->duration_days }} hari</span>
                </div>
                <ul style="list-style:none;padding:0;margin:0 0 30px;display:flex;flex-direction:column;gap:12px;font-size:13px;color:#555;">
                    <li><i class="fas fa-check" style="color:#2E7D32;margin-right:6px;"></i> Akses Seluruh Video Resep</li>
                    <li><i class="fas fa-check" style="color:#2E7D32;margin-right:6px;"></i> Chat Konsultasi Chef Privat</li>
                    <li><i class="fas fa-check" style="color:#2E7D32;margin-right:6px;"></i> Bebas Iklan & Tanpa Batas</li>
                </ul>
                <a href="{{ route('vip.checkout', $pkg) }}" class="btn" style="margin-top:auto;width:100%;justify-content:center; {{ $pkg->price <= 50000 ? 'background:var(--white);color:var(--primary);border:1px solid var(--border);' : '' }}">Pilih Paket VIP</a>
            </div>
            @empty
            <div style="grid-column: span 3; text-align:center; padding:40px; color:var(--text-m);">Belum ada paket VIP yang tersedia.</div>
            @endforelse
        </div>
    @endif
</div>
@endsection
