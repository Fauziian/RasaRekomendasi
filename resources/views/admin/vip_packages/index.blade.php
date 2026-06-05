@extends('layouts.admin')
@section('title', 'Kelola Paket VIP')
@section('content')
<div style="padding:30px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;">Paket VIP</h1>
            <p style="color:var(--text-m);font-size:14px;margin-top:4px;">Kelola paket langganan VIP untuk member platform.</p>
        </div>
        <a href="{{ route('admin.vip-packages.create') }}" class="btn" style="text-decoration:none;">
            <i class="fas fa-plus"></i> Tambah Paket
        </a>
    </div>

    @if(session('success'))
    <div style="background:#D1FAE5;border:1px solid #6EE7B7;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:14px;color:#065F46;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card" style="padding:0;overflow:hidden;border:none;box-shadow:var(--shadow-lg);">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F9FAFB;border-bottom:1px solid var(--border);">
                    <th style="padding:14px 20px;text-align:left;font-size:12px;color:var(--text-m);text-transform:uppercase;letter-spacing:.5px;">Nama Paket</th>
                    <th style="padding:14px 20px;text-align:left;font-size:12px;color:var(--text-m);text-transform:uppercase;letter-spacing:.5px;">Harga</th>
                    <th style="padding:14px 20px;text-align:left;font-size:12px;color:var(--text-m);text-transform:uppercase;letter-spacing:.5px;">Durasi</th>
                    <th style="padding:14px 20px;text-align:left;font-size:12px;color:var(--text-m);text-transform:uppercase;letter-spacing:.5px;">Status</th>
                    <th style="padding:14px 20px;text-align:center;font-size:12px;color:var(--text-m);text-transform:uppercase;letter-spacing:.5px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $pkg)
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:16px 20px;">
                        <div style="font-size:14px;font-weight:700;">{{ $pkg->name }}</div>
                        <div style="font-size:12px;color:var(--text-m);margin-top:3px;">{{ Str::limit($pkg->description, 60) }}</div>
                    </td>
                    <td style="padding:16px 20px;font-weight:700;color:var(--primary);">Rp {{ number_format($pkg->price, 0, ',', '.') }}</td>
                    <td style="padding:16px 20px;">{{ $pkg->duration_days }} hari</td>
                    <td style="padding:16px 20px;">
                        @if($pkg->is_active)
                        <span style="background:#D1FAE5;color:#065F46;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;">Aktif</span>
                        @else
                        <span style="background:#F3F4F6;color:#374151;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;">Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding:16px 20px;text-align:center;">
                        <div style="display:flex;gap:8px;justify-content:center;">
                            <form method="POST" action="{{ route('admin.vip-packages.toggle', $pkg) }}">
                                @csrf @method('PATCH')
                                <button type="submit" style="background:none;border:1px solid var(--border);padding:6px 12px;border-radius:8px;font-size:12px;cursor:pointer;">
                                    {{ $pkg->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.vip-packages.edit', $pkg) }}" style="border:1px solid var(--border);padding:6px 12px;border-radius:8px;font-size:12px;text-decoration:none;color:#333;">Edit</a>
                            <form method="POST" action="{{ route('admin.vip-packages.destroy', $pkg) }}" onsubmit="return confirm('Hapus paket ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:1px solid #FEE2E2;padding:6px 12px;border-radius:8px;font-size:12px;color:#DC2626;cursor:pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:40px;text-align:center;color:var(--text-m);">Belum ada paket VIP.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($packages->hasPages())
    <div style="margin-top:20px;">{{ $packages->links() }}</div>
    @endif
</div>
@endsection
