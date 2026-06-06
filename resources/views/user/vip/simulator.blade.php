@extends('layouts.app')
@section('title', 'Payment Gateway Simulator - RasaRekomendasi')

@push('styles')
<style>
    .sim-page {
        background: radial-gradient(circle at 20% 30%, #FFF5F2 0%, #FAF8F5 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    .sim-container {
        width: 100%;
        max-width: 500px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 90, 54, 0.15);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(160, 48, 16, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }
    .sim-header {
        background: linear-gradient(135deg, #FF5A36 0%, #D94E20 100%);
        padding: 24px;
        color: #FFF;
        text-align: center;
        position: relative;
    }
    .sim-logo {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .sim-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: 1px;
    }
    .sim-content {
        padding: 32px;
    }
    .sim-details {
        text-align: center;
        margin-bottom: 28px;
    }
    .sim-amount {
        font-size: 32px;
        font-weight: 800;
        color: #111;
        margin-bottom: 6px;
    }
    .sim-invoice {
        font-family: 'Courier New', monospace;
        font-size: 14px;
        font-weight: 700;
        color: #666;
        background: #F5F2EB;
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-block;
    }
    .info-grid {
        background: #FAF8F5;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 24px;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        padding: 8px 0;
    }
    .info-row:not(:last-child) {
        border-bottom: 1px dashed #EAE6DF;
    }
    .info-label { color: #888; }
    .info-value { font-weight: 700; color: #333; }

    /* Method visualizer */
    .method-box {
        text-align: center;
        padding: 24px;
        background: #FFF;
        border: 1.5px solid #FF5A36;
        border-radius: 16px;
        margin-bottom: 28px;
        box-shadow: 0 4px 12px rgba(255,90,54,0.04);
    }
    .method-title {
        font-size: 14px;
        font-weight: 800;
        color: #FF5A36;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .va-num {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #111;
        margin: 8px 0;
    }

    /* Simulate buttons */
    .btn-sim-success {
        width: 100%;
        padding: 14px;
        background: #2E7D32;
        color: #FFF;
        border: none;
        border-radius: 12px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 12px;
        transition: background .2s, transform 0.1s;
    }
    .btn-sim-success:hover { background: #225e25; }
    .btn-sim-success:active { transform: translateY(1px); }

    .btn-sim-fail {
        width: 100%;
        padding: 12px;
        background: transparent;
        color: #c0392b;
        border: 1.5px solid #c0392b;
        border-radius: 12px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background .2s;
    }
    .btn-sim-fail:hover { background: #FFF0F0; }

    /* Loading Spinner */
    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #FFF;
        animation: spin 1s ease-in-out infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="sim-page">
    <div class="sim-container">
        <div class="sim-header">
            <div class="sim-logo"><i class="fas fa-wallet"></i> RasaRekomendasi Secure Checkout</div>
            <div class="sim-badge">Sandbox / Simulator</div>
        </div>

        <div class="sim-content">
            <div class="sim-details">
                <div class="sim-amount">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                <div class="sim-invoice">{{ $transaction->invoice_number }}</div>
            </div>

            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Merchant</span>
                    <span class="info-value">RasaRekomendasi Store</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paket VIP</span>
                    <span class="info-value">{{ $transaction->vipPackage->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Metode Pembayaran</span>
                    <span class="info-value" style="text-transform:uppercase;">
                        @if($transaction->payment_method == 'e_wallet') E-Wallet (OVO/Gopay)
                        @elseif($transaction->payment_method == 'bank_transfer') Bank Transfer (VA)
                        @elseif($transaction->payment_method == 'credit_card') Kartu Kredit
                        @else QRIS
                        @endif
                    </span>
                </div>
            </div>

            {{-- Dynamic instructions depending on payment method --}}
            <div class="method-box">
                @if($transaction->payment_method == 'e_wallet')
                    <div class="method-title">Bayar dengan Gopay / OVO</div>
                    <p style="font-size:12px; color:#666; margin-bottom:12px;">Pindai kode QR di bawah ini dengan aplikasi e-wallet Anda:</p>
                    <div style="margin: 0 auto; width: 140px; height: 140px; padding:8px; border:1px solid #EEE; border-radius:12px;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=RasaRekomendasi-VIP-Payment" alt="QR Code" style="width:100%; height:100%;">
                    </div>
                @elseif($transaction->payment_method == 'bank_transfer')
                    <div class="method-title">Virtual Account (VA)</div>
                    <p style="font-size:12px; color:#666; margin-bottom:4px;">Salin nomor rekening Virtual Account BCA / Mandiri berikut:</p>
                    <div class="va-num">8830812345678901</div>
                    <p style="font-size:11px; color:#999; margin: 0;">Batas waktu transfer: 24 Jam</p>
                @elseif($transaction->payment_method == 'credit_card')
                    <div class="method-title">Simulasi Kartu Kredit</div>
                    <p style="font-size:12px; color:#666;">Silakan gunakan tombol simulasi pembayaran sukses di bawah untuk menyelesaikan transaksi kartu kredit Anda.</p>
                @else
                    <div class="method-title">QRIS Merchant</div>
                    <p style="font-size:12px; color:#666; margin-bottom:12px;">Pindai QRIS menggunakan aplikasi banking atau dompet digital apa saja:</p>
                    <div style="margin: 0 auto; width: 140px; height: 140px; padding:8px; border:1px solid #EEE; border-radius:12px;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=QRIS-RasaRekomendasi" alt="QRIS Code" style="width:100%; height:100%;">
                    </div>
                @endif
            </div>

            <div id="actionArea">
                <button onclick="triggerWebhook('success')" class="btn-sim-success" id="successBtn">
                    <i class="fas fa-check-circle"></i> Simulasikan Pembayaran Sukses
                </button>
                <button onclick="triggerWebhook('failed')" class="btn-sim-fail" id="failBtn">
                    <i class="fas fa-times-circle"></i> Batalkan / Gagal
                </button>
            </div>

            <div id="pollingStatus" style="text-align:center; font-size:12px; color:#888; margin-top:20px; display:flex; align-items:center; justify-content:center; gap:8px;">
                <span class="spinner" style="width:14px; height:14px; border-width:2px; border-top-color:var(--primary);"></span>
                Menunggu verifikasi sistem (Webhook)...
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Webhook callback simulation (representing external server pushing notification to our backend)
    function triggerWebhook(status) {
        // Disable buttons
        document.getElementById('successBtn').disabled = true;
        document.getElementById('failBtn').disabled = true;
        document.getElementById('successBtn').style.opacity = '0.6';
        document.getElementById('failBtn').style.opacity = '0.6';

        if (status === 'success') {
            document.getElementById('successBtn').innerHTML = '<span class="spinner"></span> Mengirim Webhook Sukses...';
        } else {
            document.getElementById('failBtn').innerHTML = 'Membatalkan...';
        }

        // Call the Webhook endpoint (backend-to-backend simulation)
        fetch('{{ route("payment.webhook") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                invoice_number: '{{ $transaction->invoice_number }}',
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Webhook triggered:', data);
            if (status === 'failed') {
                window.location.href = '{{ route("vip.index") }}?error=Pembayaran dibatalkan.';
            }
        })
        .catch(err => {
            console.error('Webhook error:', err);
            alert('Gagal mengirim simulasi callback.');
            document.getElementById('successBtn').disabled = false;
            document.getElementById('failBtn').disabled = false;
            document.getElementById('successBtn').style.opacity = '1';
            document.getElementById('failBtn').style.opacity = '1';
        });
    }

    // Poll payment status from our server database
    const pollInterval = setInterval(() => {
        fetch('{{ route("transactions.status", $transaction) }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            console.log('Current status from DB:', data.status);
            if (data.status === 'success') {
                clearInterval(pollInterval);
                // Redirect immediately to success page
                window.location.href = '{{ route("vip.success", $transaction) }}';
            } else if (data.status === 'failed' || data.status === 'expired') {
                clearInterval(pollInterval);
                window.location.href = '{{ route("vip.index") }}?error=Transaksi Anda gagal atau kedaluwarsa.';
            }
        })
        .catch(err => console.error('Polling error:', err));
    }, 2000);
</script>
@endpush
