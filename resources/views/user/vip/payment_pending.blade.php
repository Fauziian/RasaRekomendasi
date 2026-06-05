@extends('layouts.app')
@section('title', 'Menunggu Pembayaran - ' . $transaction->invoice_number)
@section('content')
<div class="page-padding" style="max-width:600px;margin:0 auto;padding-top:60px;padding-bottom:80px;">
    <div style="text-align:center;margin-bottom:40px;">
        <div style="width:80px;height:80px;background:linear-gradient(135deg,#FFF3CD,#FFE08A);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="fas fa-clock" style="font-size:36px;color:#F59E0B;"></i>
        </div>
        <h1 style="font-size:28px;font-weight:800;color:#111;margin-bottom:8px;">Menunggu Pembayaran</h1>
        <p style="color:var(--text-m);font-size:14px;">Pesanan Anda telah dibuat. Selesaikan pembayaran untuk mengaktifkan akses VIP.</p>
    </div>

    <div class="card" style="padding:30px;border:none;box-shadow:var(--shadow-lg);margin-bottom:24px;">
        <h3 style="font-size:14px;font-weight:700;color:var(--text-m);text-transform:uppercase;letter-spacing:.5px;margin-bottom:20px;">Detail Transaksi</h3>

        <div style="display:flex;flex-direction:column;gap:14px;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:14px;border-bottom:1px solid var(--border);">
                <span style="font-size:13px;color:var(--text-m);">Invoice</span>
                <span style="font-size:14px;font-weight:700;color:var(--primary);">{{ $transaction->invoice_number }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:14px;border-bottom:1px solid var(--border);">
                <span style="font-size:13px;color:var(--text-m);">Paket</span>
                <span style="font-size:14px;font-weight:600;">{{ $transaction->vipPackage->name ?? 'VIP Package' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:14px;border-bottom:1px solid var(--border);">
                <span style="font-size:13px;color:var(--text-m);">Durasi</span>
                <span style="font-size:14px;font-weight:600;">{{ $transaction->vipPackage->duration_days ?? '-' }} Hari</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:14px;border-bottom:1px solid var(--border);">
                <span style="font-size:13px;color:var(--text-m);">Metode Bayar</span>
                <span style="font-size:14px;font-weight:600;text-transform:uppercase;">{{ $transaction->payment_method }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="font-size:13px;color:var(--text-m);">Total Pembayaran</span>
                <span style="font-size:20px;font-weight:800;color:var(--primary);">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="card" style="padding:24px;border:2px dashed #FCD34D;background:#FFFBEB;box-shadow:none;margin-bottom:24px;">
        <div style="display:flex;gap:12px;align-items:flex-start;">
            <i class="fas fa-info-circle" style="color:#F59E0B;font-size:18px;margin-top:2px;flex-shrink:0;"></i>
            <div>
                <h4 style="font-size:14px;font-weight:700;margin-bottom:6px;">Instruksi Pembayaran</h4>
                <p style="font-size:13px;color:#555;margin:0;line-height:1.6;">
                    Setelah melakukan pembayaran, tim admin kami akan memverifikasi dalam <strong>1×24 jam</strong>. 
                    Status VIP Anda akan diaktifkan secara otomatis setelah pembayaran terkonfirmasi.
                </p>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:12px;flex-direction:column;">
        <a href="{{ route('transactions.index') }}" class="btn" style="width:100%;justify-content:center;text-decoration:none;">
            <i class="fas fa-receipt"></i> Lihat Riwayat Transaksi
        </a>
        <a href="{{ route('vip.index') }}" class="btn btn-white" style="width:100%;justify-content:center;text-decoration:none;">
            <i class="fas fa-crown"></i> Kembali ke Halaman VIP
        </a>
    </div>
</div>
@endsection
