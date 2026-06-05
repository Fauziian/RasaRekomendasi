@extends('layouts.admin')
@section('title', 'Laporan Transaksi')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:26px">
    <div>
        <h1 style="font-size:28px;font-weight:700;color:#111">Transactions</h1>
        <p style="color:var(--text-m);margin-top:4px">Monitor VIP membership purchases and revenue flow.</p>
    </div>
    <div style="display:flex;gap:12px">
        <div style="background:#FFF9EF;padding:10px 20px;border-radius:12px;font-size:13px;font-weight:700;">
            Total Revenue: <span style="color:var(--primary);">Rp {{ number_format($stats['success'], 0, ',', '.') }}</span>
        </div>
        <div style="background:#E3F2FD;padding:10px 20px;border-radius:12px;font-size:13px;font-weight:700;color:#1565C0;">
            Transactions: {{ $stats['count'] }}
        </div>
        @if($stats['pending'] > 0)
        <div style="background:#FEF3C7;padding:10px 20px;border-radius:12px;font-size:13px;font-weight:700;color:#92400E;">
            <i class="fas fa-clock"></i> Pending: {{ $stats['pending'] }}
        </div>
        @endif
    </div>
</div>

<div class="white-card">
    <table>
        <thead>
            <tr>
                <th style="width:150px;">Invoice / ID</th>
                <th style="width:250px;">User / Member</th>
                <th style="width:200px;">Package Purchased</th>
                <th style="width:150px;">Amount Paid</th>
                <th style="width:120px;">Status</th>
                <th>Transaction Date</th>
                <th style="text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td><strong>#INV-{{ str_pad($t->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                <td>
                    <div class="td-chef">
                        <img src="{{ $t->user->avatar_url }}" alt="">
                        <div>
                            <strong>{{ $t->user->name }}</strong><br>
                            <span style="font-size:11px;color:var(--text-m);">{{ $t->user->email }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge" style="background:#FFF9C4;color:#7c5b00;"><i class="fas fa-crown"></i> {{ $t->vipPackage->name ?? 'Premium Plan' }}</span>
                </td>
                <td><strong>Rp {{ number_format($t->amount, 0, ',', '.') }}</strong></td>
                <td>
                    <span class="badge {{ $t->payment_status == 'success' ? 'badge-active' : ($t->payment_status == 'pending' ? 'badge-pending' : 'badge-flagged') }}">
                        {{ ucfirst($t->payment_status) }}
                    </span>
                </td>
                <td style="color:var(--text-m);">{{ $t->created_at->format('M d, Y H:i') }}</td>
                <td style="text-align:center;">
                    @if($t->payment_status === 'pending')
                    <div style="display:flex;gap:6px;justify-content:center;">
                        <form method="POST" action="{{ route('admin.transactions.approve', $t) }}">
                            @csrf @method('PATCH')
                            <button type="submit" style="background:#D1FAE5;border:none;color:#065F46;padding:5px 12px;border-radius:6px;font-size:11px;font-weight:700;cursor:pointer;" onclick="return confirm('Konfirmasi pembayaran ini?')">✓ Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.transactions.reject', $t) }}">
                            @csrf @method('PATCH')
                            <button type="submit" style="background:#FEE2E2;border:none;color:#991B1B;padding:5px 12px;border-radius:6px;font-size:11px;font-weight:700;cursor:pointer;" onclick="return confirm('Tolak pembayaran ini?')">✗ Reject</button>
                        </form>
                    </div>
                    @else
                    <span style="font-size:11px;color:var(--text-m);">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-m)">Belum ada transaksi terekam.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
