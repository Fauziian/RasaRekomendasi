@extends('layouts.app')
@section('title', 'Sesi VIP Konsultasi Chef')
@section('content')
<div class="page-padding" style="padding-top:40px;padding-bottom:60px;">
    <div style="margin-bottom:35px;display:flex;justify-content:space-between;align-items:flex-end;">
        <div>
            <span class="badge badge-primary" style="margin-bottom:10px;background:#FFF9C4;color:#7c5b00;"><i class="fas fa-crown"></i> VIP Member Benefit</span>
            <h1 style="font-size:32px;font-weight:800;color:#111;">Bimbingan & Konsultasi Chef Privat</h1>
            <p style="color:var(--text-m);font-size:15px;margin-top:4px;">Tanyakan secara langsung tips memasak andalan kepada chef profesional pilihan Anda.</p>
        </div>
    </div>

    @if(!Auth::user()->hasActiveVip())
        <div class="card" style="padding:40px;text-align:center;background:linear-gradient(135deg, #FFF9C4, #FFE082);border:none;">
            <i class="fas fa-lock" style="font-size:48px;color:#f57f17;margin-bottom:15px;display:block;"></i>
            <h3 style="font-size:20px;font-weight:800;color:#5d4037;margin-bottom:10px;">Fitur Eksklusif Member VIP!</h3>
            <p style="color:#5d4037;font-size:14px;margin-bottom:20px;max-width:500px;margin-left:auto;margin-right:auto;">Anda memerlukan keanggotaan aktif VIP untuk menjadwalkan chat bimbingan kuliner privat secara virtual bersama chef.</p>
            <a href="{{ route('vip.index') }}" class="btn" style="background:#f57f17;border:none;"><i class="fas fa-crown"></i> Bergabung dengan VIP</a>
        </div>
    @else
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:35px;">
            {{-- Consultations sessions --}}
            <div class="card" style="padding:30px;border:none;box-shadow:var(--shadow-md);">
                <h3 style="font-size:18px;font-weight:800;margin-bottom:20px;">Jadwal Konsultasi Saya</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Chef Profesional</th>
                            <th>Status Sesi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $c)
                        <tr>
                            <td>
                                <div class="td-chef">
                                    <img src="{{ $c->chef->avatar_url ?? 'https://ui-avatars.com/api/?name=Chef' }}" alt="">
                                    <strong>{{ $c->chef->formatted_name }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $c->status == 'active' ? 'badge-active' : 'badge-pending' }}">{{ ucfirst($c->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('consultations.chat', $c) }}" class="btn btn-sm"><i class="fas fa-comments"></i> Buka Chat Room</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center;padding:40px;color:var(--text-m);">Anda belum menjadwalkan konsultasi apapun. Silakan pilih Chef di sebelah kanan untuk memulai!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Chefs list --}}
            <div>
                <h3 style="font-size:18px;font-weight:800;margin-bottom:20px;">Pilih Chef Profesional</h3>
                <div style="display:flex;flex-direction:column;gap:15px;">
                    @forelse($availableChefs as $chef)
                    <div class="card" style="padding:15px;display:flex;align-items:center;gap:12px;border:1px solid var(--border);">
                        <img src="{{ $chef->avatar_url }}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;" alt="">
                        <div style="flex:1;">
                            <div style="font-size:14px;font-weight:700;">{{ $chef->formatted_name }}</div>
                            <div style="font-size:11px;color:#2E7D32;"><i class="fas fa-circle" style="font-size:8px;"></i> Certified Chef</div>
                        </div>
                        <a href="{{ route('consultations.create', $chef) }}" class="btn btn-sm" style="padding:6px 12px;font-size:12px;">Booking</a>
                    </div>
                    @empty
                    <div style="color:var(--text-m);font-size:13px;text-align:center;padding:20px;">Belum ada Chef bersertifikasi yang online.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
