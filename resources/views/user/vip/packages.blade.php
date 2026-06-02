@extends('layouts.app')
@section('title', 'Pilih Paket VIP - RasaRekomendasi')

@push('styles')
<style>
/* ─── Page ──────────────────────────────────────────────── */
.vip-pg {
    background: #F5F3EF;
    min-height: 100vh;
    padding-bottom: 80px;
}

/* ─── Page Header ───────────────────────────────────────── */
.vip-pg-header {
    background: #F5F3EF;
    padding: 32px 24px 0;
    max-width: 1100px;
    margin: 0 auto;
}
.vip-back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #A03010;
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
    margin-bottom: 4px;
}
.vip-back-link:hover { opacity: .8; }

/* ─── Hero Title ─────────────────────────────────────────── */
.vip-hero {
    text-align: center;
    padding: 32px 20px 28px;
    max-width: 1100px;
    margin: 0 auto;
}
.vip-hero h1 {
    font-size: 34px;
    font-weight: 800;
    color: #A03010;
    font-family: 'Outfit', sans-serif;
    margin: 0 0 8px;
}
.vip-hero p {
    font-size: 13px;
    color: #777;
    margin: 0;
    line-height: 1.6;
    max-width: 480px;
    margin: 0 auto;
}

/* ─── Top 3 Feature Highlights ──────────────────────────── */
.feature-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    max-width: 1100px;
    margin: 0 auto 36px;
    padding: 0 24px;
}
.feat-card {
    background: #FFF;
    border-radius: 18px;
    padding: 22px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.feat-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.feat-icon.orange { background: #FFE8D6; color: #D94E1F; }
.feat-icon.green  { background: #D7F4E4; color: #2A8C5A; }
.feat-icon.blue   { background: #D6EAFF; color: #1A6DB5; }

.feat-card h4 {
    font-size: 14px;
    font-weight: 800;
    color: #111;
    margin: 0 0 2px;
}
.feat-card p {
    font-size: 12px;
    color: #888;
    line-height: 1.5;
    margin: 0;
}

/* ─── Pricing Cards ─────────────────────────────────────── */
.pricing-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
    margin-bottom: 48px;
}
.pricing-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    align-items: start;
}

.pkg-card {
    background: #FFF;
    border: 1.5px solid #E8E3DC;
    border-radius: 22px;
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: box-shadow .25s, transform .25s;
}
.pkg-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,.08);
    transform: translateY(-4px);
}
.pkg-card.feat {
    border-color: #C94525;
    box-shadow: 0 10px 32px rgba(160,48,16,.14);
}
.pkg-card.feat:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(160,48,16,.2);
}

/* "PALING POPULER" floating badge */
.pop-badge {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    background: #C94525;
    color: #FFF;
    font-size: 10px;
    font-weight: 800;
    padding: 5px 16px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: .6px;
    white-space: nowrap;
}

/* Small label above name */
.pkg-label {
    font-size: 10px;
    font-weight: 800;
    color: #A03010;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-bottom: 6px;
}
.pkg-name {
    font-size: 20px;
    font-weight: 800;
    color: #111;
    margin: 0 0 6px;
}
.pkg-card.feat .pkg-name { color: #A03010; }
.pkg-desc {
    font-size: 12px;
    color: #888;
    line-height: 1.5;
    margin: 0 0 18px;
    flex-grow: 0;
}

/* Price row */
.pkg-price-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-bottom: 20px;
}
.pkg-price {
    font-size: 28px;
    font-weight: 800;
    color: #A03010;
}
.pkg-period {
    font-size: 12px;
    color: #999;
    font-weight: 500;
}

/* Features */
.pkg-feats {
    list-style: none;
    padding: 0;
    margin: 0 0 28px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex-grow: 1;
}
.pkg-feats li {
    font-size: 12.5px;
    color: #444;
    display: flex;
    align-items: center;
    gap: 10px;
}
.pkg-feats .chk {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #E9F7EE;
    color: #2A8C5A;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    flex-shrink: 0;
}
.pkg-card.feat .pkg-feats .chk {
    background: #FFE8D6;
    color: #D94E1F;
}

/* CTA Buttons */
.pkg-btn {
    display: block;
    width: 100%;
    padding: 13px;
    border-radius: 14px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 800;
    text-align: center;
    text-decoration: none;
    border: none;
    cursor: pointer;
    letter-spacing: .3px;
    transition: opacity .2s, transform .15s;
}
.pkg-btn:hover { opacity: .88; transform: translateY(-1px); }
.pkg-btn.outline {
    background: transparent;
    border: 1.5px solid #D8D2C9;
    color: #444;
}
.pkg-btn.outline:hover { border-color: #A03010; color: #A03010; }
.pkg-btn.solid {
    background: linear-gradient(135deg, #E05528, #A03010);
    color: #FFF;
}

/* ─── "Mengapa Harus VIP?" section ──────────────────────── */
.why-vip {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}
.why-img {
    border-radius: 22px;
    overflow: hidden;
    height: 300px;
}
.why-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.why-content h2 {
    font-size: 26px;
    font-weight: 800;
    color: #111;
    margin: 0 0 10px;
    font-family: 'Outfit', sans-serif;
}
.why-content p {
    font-size: 13px;
    color: #777;
    line-height: 1.7;
    margin: 0 0 24px;
}
.why-stats {
    display: flex;
    gap: 28px;
}
.stat-item {}
.stat-num {
    font-size: 26px;
    font-weight: 800;
    color: #A03010;
    line-height: 1;
    margin-bottom: 4px;
}
.stat-lbl {
    font-size: 11px;
    color: #888;
    font-weight: 600;
}

/* ─── VIP Member Alert ───────────────────────────────────── */
.vip-already {
    background: linear-gradient(135deg, #FFF9C4, #FFE082);
    border: 1px solid #FFC107;
    border-radius: 22px;
    padding: 40px;
    text-align: center;
    max-width: 1100px;
    margin: 0 auto 40px;
}
.vip-already i { font-size: 46px; color: #F57F17; display: block; margin-bottom: 14px; }
.vip-already h3 { font-size: 20px; font-weight: 800; color: #5D4037; margin: 0 0 8px; }
.vip-already p  { font-size: 13px; color: #6D4C41; margin: 0 0 20px; line-height: 1.6; }

/* ─── Responsive ─────────────────────────────────────────── */
@media (max-width: 900px) {
    .feature-strip   { grid-template-columns: 1fr; }
    .pricing-grid    { grid-template-columns: 1fr; }
    .why-vip         { grid-template-columns: 1fr; }
    .pkg-card.feat   { box-shadow: 0 6px 20px rgba(160,48,16,.12); }
}
@media (max-width: 560px) {
    .vip-hero h1 { font-size: 26px; }
    .why-stats   { flex-direction: column; gap: 16px; }
}
</style>
@endpush

@section('content')
<div class="vip-pg">

    {{-- ── Page Header ── --}}
    <div class="vip-pg-header">
        <a href="{{ route('welcome') }}" class="vip-back-link">
            <i class="fas fa-arrow-left"></i> Pilih Paket VIP
        </a>
    </div>

    {{-- ── Hero Title ── --}}
    <div class="vip-hero">
        <h1>Tingkatkan Pengalaman Memasak</h1>
        <p>Dapatkan akses eksklusif ke fitur–fitur premium yang dirancang khusus untuk mempercepat keahlian dapurmu.</p>
    </div>

    {{-- ── 3 Feature Highlight Cards ── --}}
    <div class="feature-strip">
        <div class="feat-card">
            <div class="feat-icon orange"><i class="fas fa-play-circle"></i></div>
            <div>
                <h4>Video Tutorial Eksklusif</h4>
                <p>Akses ratusan video masak berkualitas tinggi dari koki profesional dengan teknik rahasia.</p>
            </div>
        </div>
        <div class="feat-card">
            <div class="feat-icon green"><i class="fas fa-comments"></i></div>
            <div>
                <h4>Chef Chat 24/7</h4>
                <p>Konsultasi langsung dengan koki ahli kapan saja jika kamu bingung saat sedang memasak.</p>
            </div>
        </div>
        <div class="feat-card">
            <div class="feat-icon blue"><i class="fas fa-calendar-check"></i></div>
            <div>
                <h4>Prioritas Booking</h4>
                <p>Jadwalkan kelas memasak private dan workshop offline lebih awal dibanding pengguna lain.</p>
            </div>
        </div>
    </div>

    {{-- ── Pricing Cards ── --}}
    <div class="pricing-wrap">

        @if(Auth::check() && Auth::user()->is_vip)
        <div class="vip-already">
            <i class="fas fa-crown"></i>
            <h3>Status Keanggotaan Anda: VIP Member 👑</h3>
            <p>Terima kasih atas langganan VIP Anda! Nikmati seluruh resep premium, video tutorial, serta konsultasi chat privat bersama Chef profesional.</p>
            <a href="{{ route('recipes.index') }}" style="display:inline-flex;align-items:center;gap:8px;background:#F57F17;color:#FFF;font-weight:700;padding:12px 28px;border-radius:20px;text-decoration:none;">
                <i class="fas fa-utensils"></i> Jelajah Resep VIP
            </a>
        </div>
        @else
        <div class="pricing-grid">
            @forelse($packages as $pkg)
            @php
                $isFeatured = $pkg->price == 129000;
                $isWeekly   = $pkg->price == 49000;
                $isQuarter  = $pkg->price == 299000;

                if ($isWeekly) {
                    $label   = 'COBA DULU';
                    $name    = 'VIP Mingguan';
                    $desc    = 'Cocok untuk mencoba semua fitur premium selama satu minggu penuh.';
                    $period  = '/minggu';
                    $feats   = ['Akses Video Tutorial', 'Chef Chat (3m Kerja)'];
                    $btnText = 'PILIH PAKET';
                    $btnCls  = 'outline';
                } elseif ($isFeatured) {
                    $label   = 'TERBAIK';
                    $name    = 'VIP Bulanan';
                    $desc    = 'Pilihan favorit para Gen Z chef untuk konsistensi belajar setiap hari.';
                    $period  = '/bulan';
                    $feats   = ['Akses Video 4K & Offline', 'Chef Chat 24/7 Unlimited', 'E-Book Resep Bulanan'];
                    $btnText = 'AMBIL PROMO INI';
                    $btnCls  = 'solid';
                } elseif ($isQuarter) {
                    $label   = 'HEMAT 30%';
                    $name    = 'VIP 3 Bulan';
                    $desc    = 'Investasi jangka panjang untuk kamu yang serius ingin jadi pro.';
                    $period  = '/3 bulan';
                    $feats   = ['Semua Fitur Bulanan', 'Sertifikat Keahlian Rasa', 'Merchandise Eksklusif'];
                    $btnText = 'PILIH PAKET';
                    $btnCls  = 'outline';
                } else {
                    $label   = '';
                    $name    = $pkg->name;
                    $desc    = '';
                    $period  = '/' . $pkg->duration_days . ' hari';
                    $feats   = ['Akses Seluruh Video Resep', 'Chat Konsultasi Chef Privat', 'Bebas Iklan & Tanpa Batas'];
                    $btnText = 'PILIH PAKET';
                    $btnCls  = 'outline';
                }
            @endphp

            <div class="pkg-card {{ $isFeatured ? 'feat' : '' }}">
                @if($isFeatured)
                    <div class="pop-badge">PALING POPULER</div>
                @endif

                <div class="pkg-label">{{ $label }}</div>
                <div class="pkg-name">{{ $name }}</div>
                <p class="pkg-desc">{{ $desc }}</p>

                <div class="pkg-price-row">
                    <span class="pkg-price">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                    <span class="pkg-period">{{ $period }}</span>
                </div>

                <ul class="pkg-feats">
                    @foreach($feats as $feat)
                    <li>
                        <span class="chk"><i class="fas fa-check"></i></span>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('vip.checkout', $pkg) }}" class="pkg-btn {{ $btnCls }}">
                    {{ $btnText }}
                </a>
            </div>
            @empty
            <p style="grid-column:span 3; text-align:center; color:#777; padding:40px;">
                Belum ada paket VIP tersedia.
            </p>
            @endforelse
        </div>
        @endif
    </div>

    {{-- ── Mengapa Harus VIP? Section ── --}}
    <div class="why-vip">
        <div class="why-img">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800&q=80" alt="Chef memasak">
        </div>
        <div class="why-content">
            <h2>Mengapa Harus VIP?</h2>
            <p>Bergabunglah dengan lebih dari 10.000+ koki rumah tangga di Indonesia yang telah meningkatkan kualitas masakan mereka dengan RasaRekomendasi VIP.</p>
            <div class="why-stats">
                <div class="stat-item">
                    <div class="stat-num">85%</div>
                    <div class="stat-lbl">Lebih Percaya Diri</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">200+</div>
                    <div class="stat-lbl">Resep Rahasia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">10K+</div>
                    <div class="stat-lbl">Member Aktif</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
