@extends('layouts.app')
@section('title', 'Pilih Jadwal Chef ' . $chef->name)
@section('content')
<div class="page-padding" style="max-width:600px;margin:0 auto;padding-top:40px;padding-bottom:60px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('consultations.index') }}" class="btn btn-white btn-sm" style="margin-bottom:15px;"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1 style="font-size:28px;font-weight:800;color:#111;">Booking Konsultasi Privat</h1>
        <p style="color:var(--text-m);font-size:14px;margin-top:4px;">Pilih jadwal ketersediaan untuk berkonsultasi privat bersama <strong>Chef {{ $chef->name }}</strong>.</p>
    </div>

    <form method="POST" action="{{ route('consultations.store', $chef) }}" class="card" style="padding:30px;border:none;box-shadow:var(--shadow-lg);">
        @csrf
        
        <div style="display:flex;align-items:center;gap:15px;background:#FDFCF8;padding:15px;border-radius:12px;margin-bottom:24px;border:1px solid var(--border);">
            <img src="{{ $chef->avatar_url }}" style="width:50px;height:50px;border-radius:50%;object-fit:cover;" alt="">
            <div>
                <h4 style="font-size:15px;font-weight:700;margin:0;">Chef {{ $chef->name }}</h4>
                <p style="font-size:11px;color:var(--text-m);margin:0;">Certified Professional Instructor</p>
            </div>
        </div>

        <div class="form-group" style="margin-bottom:24px;">
            <label class="form-label" style="font-size:12px;font-weight:700;">JADWAL KONSULTASI YANG TERSEDIA</label>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @forelse($schedules as $sched)
                <label style="border:1px solid var(--border);padding:14px;border-radius:12px;display:flex;align-items:center;gap:12px;cursor:pointer;transition:all .2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                    <input type="radio" name="schedule_id" value="{{ $sched->id }}" style="accent-color:var(--primary);width:18px;height:18px;" required>
                    <i class="far fa-calendar-alt" style="font-size:18px;color:var(--primary);"></i>
                    <span style="font-size:13px;font-weight:600;">
                        {{ \Carbon\Carbon::parse($sched->available_date)->format('l, d M Y') }} 
                        ({{ \Carbon\Carbon::parse($sched->available_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($sched->available_time_end)->format('H:i') }})
                    </span>
                </label>
                @empty
                <div style="text-align:center;padding:20px;color:var(--text-m);font-size:13px;">Chef belum merilis jadwal ketersediaan terbaru saat ini.</div>
                @endforelse
            </div>
        </div>

        @if($schedules->count() > 0)
        <button type="submit" class="btn" style="width:100%;justify-content:center;padding:12px;"><i class="fas fa-check-circle"></i> Jadwalkan Sesi Sekarang</button>
        @endif
    </form>
</div>
@endsection
