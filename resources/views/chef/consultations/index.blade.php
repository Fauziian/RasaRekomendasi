@extends('layouts.chef')
@section('title', 'Daftar Konsultasi VIP')
@section('content')
<div style="margin-bottom:26px">
    <h1 style="font-size:28px;font-weight:700;color:#111">Daftar Konsultasi VIP</h1>
    <p style="color:var(--text-m);margin-top:4px">Bantu dan berikan instruksi kepada user yang berlangganan sesi VIP Anda.</p>
</div>

<div class="white-card">
    <table>
        <thead>
            <tr>
                <th>User / Member VIP</th>
                <th>Status Konsultasi</th>
                <th>Sesi Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultations as $c)
            <tr>
                <td>
                    <div class="td-chef">
                        <img src="{{ $c->user->avatar_url }}" alt="">
                        <div>
                            <strong>{{ $c->user->name }}</strong><br>
                            <span style="font-size:11px;color:var(--text-m);">{{ $c->user->email }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge {{ $c->status == 'active' ? 'badge-active' : 'badge-pending' }}">{{ ucfirst($c->status) }}</span>
                </td>
                <td style="color:var(--text-m);">{{ $c->created_at->format('l, d M Y H:i') }}</td>
                <td>
                    <a href="{{ route('chef.consultations.chat', $c) }}" class="btn btn-primary btn-sm"><i class="fas fa-comments"></i> Buka Chat</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:40px;color:var(--text-m)">Belum ada sesi konsultasi yang dibuat.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        {{ $consultations->links() }}
    </div>
</div>
@endsection
