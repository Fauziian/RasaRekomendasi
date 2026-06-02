@extends('layouts.chef')
@section('title', 'Earnings')
@section('content')
<div style="margin-bottom:26px">
    <h1 style="font-size:28px;font-weight:700;color:#111">Manajemen Pendapatan</h1>
    <p style="color:var(--text-m);margin-top:4px">Lacak total pendapatan sesi konsultasi VIP dan pencairan dana Anda secara berkala.</p>
</div>

<!-- Financial Summary Grid -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:24px; margin-bottom:30px;">
    <!-- Balance Card -->
    <div class="white-card" style="margin-bottom:0; background:linear-gradient(135deg, #FF5A36, #FF7B5E); color:#FFF; border:none; box-shadow: 0 10px 25px rgba(255,90,54,0.2);">
        <div style="display:flex; justify-content:between; align-items:flex-start; width:100%;">
            <div style="flex:1;">
                <div style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; opacity:0.9;">Total Pendapatan</div>
                <div style="font-size:32px; font-weight:800; margin-top:6px; font-family:'Outfit',sans-serif;">Rp 4.200.000</div>
                <div style="font-size:11px; margin-top:14px; opacity:0.95; display:inline-flex; align-items:center; gap:4px;">
                    <i class="fas fa-arrow-trend-up"></i> +15% dari minggu lalu
                </div>
            </div>
            <div style="width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; font-size:20px;">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Pending Payout -->
    <div class="white-card" style="margin-bottom:0; display:flex; align-items:center; gap:18px; border:1px solid #F0F0F0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="width:52px; height:52px; border-radius:12px; background:#FFF9EF; color:#FF9800; display:flex; align-items:center; justify-content:center; font-size:22px;">
            <i class="fas fa-clock"></i>
        </div>
        <div style="flex:1;">
            <div style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.5px;">Dana Tertunda</div>
            <div style="font-size:24px; font-weight:800; color:#111; margin-top:2px;">Rp 1.500.000</div>
            <div style="font-size:11px; color:#FF9800; font-weight:700; margin-top:4px;">Pencairan otomatis pada 5 Juni 2026</div>
        </div>
    </div>

    <!-- Active Premium Subscribers -->
    <div class="white-card" style="margin-bottom:0; display:flex; align-items:center; gap:18px; border:1px solid #F0F0F0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="width:52px; height:52px; border-radius:12px; background:#E8F5E9; color:#2E7D32; display:flex; align-items:center; justify-content:center; font-size:22px;">
            <i class="fas fa-users"></i>
        </div>
        <div style="flex:1;">
            <div style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.5px;">Langganan VIP Aktif</div>
            <div style="font-size:24px; font-weight:800; color:#111; margin-top:2px;">12 Member</div>
            <div style="font-size:11px; color:#2E7D32; font-weight:700; margin-top:4px;">Tarif: Rp 150K / Sesi Konsultasi</div>
        </div>
    </div>
</div>

<!-- Transactions Table and Withdrawal Form Layout -->
<div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
    <!-- History of Earnings -->
    <div class="white-card" style="border:1px solid #F0F0F0; margin-bottom:0;">
        <div class="card-hdr" style="margin-bottom:18px;">
            <div>
                <h3 style="font-size:18px; font-weight:800;">Riwayat Penerimaan Dana</h3>
                <p style="font-size:12px; color:var(--text-m); margin-top:2px;">Daftar transaksi pembayaran konsultasi dari pengguna VIP.</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Deskripsi Konsultasi</th>
                    <th>User</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Konsultasi VIP Private — Rendang Daging Sapi</strong></td>
                    <td>Budi Kurniawan</td>
                    <td style="color:#777;">24 May 2026</td>
                    <td style="font-weight:700; color:#2E7D32;">+Rp 150.000</td>
                    <td><span class="badge badge-pub" style="font-weight:800;">Selesai</span></td>
                </tr>
                <tr>
                    <td><strong>Konsultasi VIP Private — Lapis Legit Premium</strong></td>
                    <td>Siti Rahma</td>
                    <td style="color:#777;">22 May 2026</td>
                    <td style="font-weight:700; color:#2E7D32;">+Rp 150.000</td>
                    <td><span class="badge badge-pub" style="font-weight:800;">Selesai</span></td>
                </tr>
                <tr>
                    <td><strong>Konsultasi VIP Private — Ramen Tonkotsu Homemade</strong></td>
                    <td>Adit Pratama</td>
                    <td style="color:#777;">18 May 2026</td>
                    <td style="font-weight:700; color:#2E7D32;">+Rp 150.000</td>
                    <td><span class="badge badge-pub" style="font-weight:800;">Selesai</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Payout Widget -->
    <div class="white-card" style="border:1px solid #F0F0F0; display:flex; flex-direction:column; justify-content:space-between; margin-bottom:0;">
        <div>
            <h3 style="font-size:16px; font-weight:800; color:#111; margin-bottom:16px; padding-bottom:8px; border-bottom:1px solid #F0EDE8;"><i class="fas fa-bank" style="color:#FF5A36; margin-right:6px;"></i> Tarik Saldo</h3>
            
            <div style="background:#FFF9EF; border:1px solid #FFE0B2; border-radius:10px; padding:12px; font-size:12px; color:#A06000; font-weight:600; line-height:1.5; margin-bottom:16px;">
                Batas minimum penarikan adalah Rp 100.000. Dana akan dikirim ke rekening bank utama terdaftar.
            </div>

            <div class="form-group" style="margin-bottom:14px;">
                <label class="form-label" style="font-size:10px; color:#777;">REKENING TUJUAN</label>
                <div style="font-size:13.5px; font-weight:800; color:#111; margin-top:2px;">Bank BCA — 1234****56</div>
                <div style="font-size:11px; color:#aaa; margin-top:1px;">a.n Rina Sari</div>
            </div>

            <div class="form-group" style="margin-bottom:20px;">
                <label class="form-label" style="font-size:10px; color:#777;">NOMINAL PENARIKAN (RP)</label>
                <input type="number" placeholder="Contoh: 1500000" class="form-control" style="background:#FAF8F5; height:44px; border-radius:8px; font-weight:700;">
            </div>
        </div>

        <button onclick="alert('Permintaan penarikan dana berhasil dikirim! Silakan tunggu 1-2 hari kerja.')" class="btn btn-primary" style="width:100%; height:44px; justify-content:center; border-radius:12px; font-weight:700;">Tarik Dana Sekarang</button>
    </div>
</div>
@endsection
