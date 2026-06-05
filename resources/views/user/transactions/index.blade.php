@extends('layouts.app')
@section('title', 'Riwayat Transaksi VIP')
@section('content')
<div class="page-padding" style="padding-top:40px;padding-bottom:60px;">
    <div style="max-width:900px;margin:0 auto;">
        <div style="margin-bottom:30px;">
            <h1 style="font-size:28px;font-weight:800;color:#111;">Riwayat Transaksi</h1>
            <p style="color:var(--text-m);font-size:14px;margin-top:4px;">Semua transaksi pembelian paket VIP Anda.</p>
        </div>

        @if(session('success'))
        <div style="background:#D1FAE5;border:1px solid #6EE7B7;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:14px;color:#065F46;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <div class="card" style="padding:0;overflow:hidden;border:none;box-shadow:var(--shadow-lg);">
            @forelse($transactions as $tx)
            <div style="padding:20px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <div style="flex:1;min-width:200px;">
                    <div style="font-size:14px;font-weight:700;">{{ $tx->vipPackage->name ?? 'VIP Package' }}</div>
                    <div style="font-size:12px;color:var(--text-m);margin-top:3px;">{{ $tx->invoice_number }}</div>
                    <div style="font-size:11px;color:var(--text-m);margin-top:2px;">{{ $tx->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div style="text-align:center;min-width:100px;">
                    <div style="font-size:12px;color:var(--text-m);">Metode</div>
                    <div style="font-size:13px;font-weight:600;text-transform:uppercase;">{{ $tx->payment_method }}</div>
                </div>
                <div style="text-align:center;min-width:120px;">
                    <div style="font-size:12px;color:var(--text-m);">Total</div>
                    <div style="font-size:15px;font-weight:800;color:var(--primary);">Rp {{ number_format($tx->amount, 0, ',', '.') }}</div>
                </div>
                <div style="min-width:100px;text-align:right;">
                    @php
                        $statusColors = [
                            'success'  => ['bg'=>'#D1FAE5','text'=>'#065F46','label'=>'Berhasil'],
                            'pending'  => ['bg'=>'#FEF3C7','text'=>'#92400E','label'=>'Pending'],
                            'failed'   => ['bg'=>'#FEE2E2','text'=>'#991B1B','label'=>'Gagal'],
                            'expired'  => ['bg'=>'#F3F4F6','text'=>'#374151','label'=>'Expired'],
                            'refunded' => ['bg'=>'#DBEAFE','text'=>'#1E40AF','label'=>'Refund'],
                        ];
                        $s = $statusColors[$tx->payment_status] ?? ['bg'=>'#F3F4F6','text'=>'#374151','label'=>ucfirst($tx->payment_status)];
                    @endphp
                    <span style="background:{{ $s['bg'] }};color:{{ $s['text'] }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;">
                        {{ $s['label'] }}
                    </span>
                    @if($tx->payment_status === 'pending')
                    <div style="margin-top:8px;">
                        <a href="{{ route('transactions.pending', $tx) }}" style="font-size:11px;color:var(--primary);text-decoration:none;font-weight:600;">Lihat Detail →</a>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="padding:60px;text-align:center;color:var(--text-m);">
                <i class="fas fa-receipt" style="font-size:40px;margin-bottom:16px;display:block;opacity:.3;"></i>
                <div style="font-size:15px;font-weight:600;">Belum ada transaksi</div>
                <div style="font-size:13px;margin-top:6px;">Berlangganan VIP untuk menikmati fitur premium.</div>
                <a href="{{ route('vip.index') }}" class="btn" style="margin-top:20px;display:inline-flex;text-decoration:none;">
                    <i class="fas fa-crown"></i> Pilih Paket VIP
                </a>
            </div>
            @endforelse
        </div>

        @if($transactions->hasPages())
        <div style="margin-top:24px;">{{ $transactions->links() }}</div>
        @endif
    </div>
</div>
@endsection
