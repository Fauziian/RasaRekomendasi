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
