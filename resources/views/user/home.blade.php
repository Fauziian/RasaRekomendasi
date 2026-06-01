@extends('layouts.app')

@section('title', Auth::check() ? 'Dashboard' : 'Beranda')
@section('description', 'Temukan ribuan resep masakan Indonesia autentik dengan rekomendasi personal dan konsultasi chef profesional.')

@push('styles')
<style>
    /* ────────────────────────────────────────────────────────
       ✨ COMMON DESIGN VARIABLES & KEYFRAMES
       ──────────────────────────────────────────────────────── */
    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.8; }
    }
    @keyframes growWidth {
        from { width: 0; }
        to { width: 15%; }
    }

    /* ────────────────────────────────────────────────────────
       🚀 1. GUEST LANDING PAGE (RasaRekomendasi v2)
       ──────────────────────────────────────────────────────── */
    .landing-hero {
        padding: 60px 5%;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 60px;
        align-items: center;
        background: radial-gradient(circle at 80% 20%, #FFF5F2 0%, transparent 50%);
    }
    .hero-h1 {
        font-size: 52px;
        font-weight: 800;
        color: #111;
        line-height: 1.15;
        font-family: 'Outfit', sans-serif;
        margin-bottom: 20px;
    }
    .hero-h1 span {
        color: var(--primary);
    }
    .hero-desc {
        font-size: 16px;
        color: var(--text-m);
        line-height: 1.6;
        margin-bottom: 32px;
        max-width: 520px;
    }
    .hero-visual-card {
        position: relative;
        background: #FFF;
        border-radius: 32px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid #F0F0F0;
    }
    .hero-visual-card img {
        width: 100%;
        height: 480px;
        object-fit: cover;
    }
    .hero-floating-badge {
        position: absolute;
        bottom: 24px;
        left: 24px;
        background: #E8F5E9;
        border: 1.5px solid #A5D6A7;
        color: #2E7D32;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    /* Resep Populer Minggu Ini */
    .trending-big-card {
        background: #FFF;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #F0F0F0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: transform 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .trending-big-card:hover {
        transform: translateY(-6px);
    }
    .trending-big-card img {
        width: 100%;
        height: 380px;
        object-fit: cover;
    }

    /* ── CTA Banner ── */
    .upgrade-banner {
        background: linear-gradient(135deg, #E04D2C 0%, #FF5A36 100%);
        border-radius: 30px;
        padding: 50px;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 40px;
        align-items: center;
        color: #FFF;
        margin: 60px 0;
    }
    .upgrade-price-card {
        background: #FFF;
        border-radius: 20px;
        padding: 32px;
        color: #333;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        text-align: center;
    }

    /* ────────────────────────────────────────────────────────
       🛡️ 2. AUTHENTICATED USER DASHBOARD (User Dashboard v2)
       ──────────────────────────────────────────────────────── */
    .dashboard-container {
        display: grid;
        grid-template-columns: 240px 1fr;
        min-height: 90vh;
        background: #FAF9F6;
    }
    
    /* Left Sidebar */
    .dash-sidebar {
        background: #FFF;
        border-right: 1px solid #EAE6DF;
        padding: 32px 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .dash-menu {
        list-style: none;
    }
    .dash-menu li a {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 28px;
        color: #555;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
        border-left: 4px solid transparent;
    }
    .dash-menu li a:hover, .dash-menu li a.active {
        background: #FFF0EC;
        color: var(--primary);
        font-weight: 700;
    }
    .dash-menu li a.active {
        border-left-color: var(--primary);
    }

    /* Right Main Panel */
    .dash-main {
        padding: 40px;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #FF6A48 0%, #FF5A36 100%);
        border-radius: 24px;
        padding: 36px 44px;
        color: #FFF;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 36px rgba(255,90,54,0.15);
        margin-bottom: 32px;
    }
    .vip-pill {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 14px;
    }

    /* Tiles Grid Row */
    .tiles-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 36px;
    }
    .tile-card {
        background: #FFF;
        border-radius: 16px;
        padding: 22px;
        text-align: center;
        border: 1px solid #EAE6DF;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    .tile-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary);
    }
    .tile-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    /* Main Grid Split */
    .dashboard-split {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 28px;
    }
    .recipe-card-modern {
        background: #FFF;
        border-radius: 20px;
        border: 1px solid #EAE6DF;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.02);
        transition: transform 0.2s;
    }
    .recipe-card-modern:hover {
        transform: translateY(-4px);
    }
    .recipe-card-modern img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }
    .recipe-tag-pill {
        position: absolute;
        top: 14px;
        left: 14px;
        background: #2E7D32;
        color: #FFF;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
    }

    /* Floating Heart Button */
    .heart-float {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #FFF;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FF5A36;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border: none;
        cursor: pointer;
    }

    /* Recent Activity Item */
    .activity-item {
        display: flex;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid #F0EFEA;
    }
    .activity-item:last-child {
        border-bottom: none;
    }
    .activity-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    @media (max-width: 1024px) {
        .dashboard-container { grid-template-columns: 1fr; }
        .dash-sidebar { display: none; }
        .tiles-row { grid-template-columns: repeat(3, 1fr); }
        .dashboard-split { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

@guest
    <!-- ────────────────────────────────────────────────────────
         ✨ GUEST LANDING PAGE (Landing Page - RasaRekomendasi v2)
         ──────────────────────────────────────────────────────── -->
    <!-- Hero Block -->
    <section class="landing-hero">
        <div style="padding-right: 20px;">
            <div style="font-size: 11px; font-weight: 800; color: var(--primary); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 12px;">🏆 AI-POWERED RECOMMENDATIONS</div>
            <h1 class="hero-h1">Temukan Resep Sesuai Selera dan Jadilah <span>Member VIP</span> untuk Akses Fitur Premium</h1>
            <p class="hero-desc">Nikmati perjalanan kuliner yang dipersonalisasi khusus untuk kamu. Dari resep viral hingga teknik chef profesional, semua ada dalam satu genggaman.</p>
            <div style="display:flex; gap:16px; align-items:center; flex-wrap:wrap;">
                <a href="{{ route('recipes.index') }}" class="btn" style="padding: 14px 28px; border-radius: 30px; background: var(--primary); color:#FFF; font-weight:700;">Cari Resep <i class="fas fa-arrow-right"></i></a>
                <a href="{{ route('vip.index') }}" class="btn" style="padding: 14px 28px; border-radius: 30px; background: #FFF; border: 1.5px solid #EEE; color:#111; font-weight:700;">Lihat Paket VIP</a>
            </div>
            <!-- Trust Pilot Counts -->
            <div style="display:flex; align-items:center; gap:12px; margin-top:32px;">
                <div style="display:flex; -webkit-margin-start: -8px;">
                    <img src="https://i.pravatar.cc/80?img=33" style="width:32px; height:32px; border-radius:50%; border:2px solid #FFF;" alt="">
                    <img src="https://i.pravatar.cc/80?img=12" style="width:32px; height:32px; border-radius:50%; border:2px solid #FFF; margin-left:-8px;" alt="">
                    <img src="https://i.pravatar.cc/80?img=47" style="width:32px; height:32px; border-radius:50%; border:2px solid #FFF; margin-left:-8px;" alt="">
                </div>
                <span style="font-size:12px; font-weight:700; color:#555;">Bergabung dengan <strong style="color:var(--primary)">50.000+</strong> Home Chef Indonesia</span>
            </div>
        </div>

        <div class="hero-visual-card">
            <!-- Dynamic delicious beef bowl display -->
            <img src="https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=800&q=80" alt="Special Gyudon Beef Bowl">
            <div class="hero-floating-badge">
                <i class="fas fa-crown" style="color:#FFA500;"></i>
                <span><strong>VERIFIED MEMBER</strong><br>VIP Access Active</span>
            </div>
        </div>
    </section>

    <!-- Resep Populer Minggu Ini Section -->
    <section class="section" style="margin-top:40px;">
        <div class="section-header" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px;">
            <div>
                <h2 style="font-size:26px; font-weight:800; color:#111;">Resep Populer Minggu Ini</h2>
                <p style="color:var(--text-m); font-size:13px; margin-top:4px;">Pilihan terbaik dari komunitas RasaRekomendasi.</p>
            </div>
            <a href="{{ route('recipes.index') }}" style="color:var(--primary); font-weight:800; font-size:13px;">Lihat Semua ></a>
        </div>

        <div style="display:grid; grid-template-columns: 1.1fr 0.9fr; gap:24px;">
            <!-- Big card left -->
            <div class="trending-big-card">
                <div style="position:relative;">
                    <img src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?q=80&w=800" alt="Nasi Goreng Gila Jakarta">
                    <span style="position:absolute; bottom:16px; left:16px; background:#FF9800; color:#FFF; font-size:10px; font-weight:800; padding:4px 10px; border-radius:4px;">TRENDING</span>
                </div>
                <div style="padding:24px; flex:1; display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <div style="display:flex; gap:10px; font-size:11px; font-weight:700; color:#999; margin-bottom:8px;">
                            <span>15 MINS</span>
                            <span>•</span>
                            <span>EASY</span>
                        </div>
                        <h3 style="font-size:22px; font-weight:800; color:#111; line-height:1.3;">Nasi Goreng Gila Jakarta</h3>
                        <p style="color:var(--text-m); font-size:13px; margin-top:6px; line-height:1.5;">Nasi goreng kaya rasa dengan toping sosis, bakso, kol, dan telur orak-arik gila pedas.</p>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px; padding-top:16px; border-top:1px solid #F0F0F0;">
                        <span style="font-size:12px; color:#777;"><i class="far fa-eye"></i> 1.2k views</span>
                        <span style="color:#FFA500; font-weight:800; font-size:13px;"><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>

            <!-- Small cards grid right -->
            <div style="display:grid; grid-template-rows: auto 1fr; gap:20px;">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                    <!-- Salad Salmon -->
                    <div class="trending-big-card" style="height:auto;">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80" style="height:150px;" alt="">
                        <div style="padding:16px;">
                            <h4 style="font-size:14px; font-weight:800; color:#111;">Salad Salmon Alpukat</h4>
                            <p style="font-size:11px; color:#999; margin-top:4px;">Healthy • Keto</p>
                        </div>
                    </div>
                    <!-- Lava Cake -->
                    <div class="trending-big-card" style="height:auto;">
                        <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400&q=80" style="height:150px;" alt="">
                        <div style="padding:16px;">
                            <h4 style="font-size:14px; font-weight:800; color:#111;">Lava Cake Cokelat</h4>
                            <p style="font-size:11px; color:#999; margin-top:4px;">Rich • Sweet</p>
                        </div>
                    </div>
                </div>

                <!-- Smoothie Bowl Tropis (Large landscape card) -->
                <div class="trending-big-card" style="position:relative;">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=600&q=80" style="height:100%; min-height:180px;" alt="">
                    <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.8), transparent); padding:20px; color:#FFF;">
                        <h4 style="font-size:18px; font-weight:800; margin:0;">Smoothie Bowl Tropis</h4>
                        <p style="font-size:12px; opacity:0.8; margin-top:4px;">Booster Energi Pagi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Benefits Section -->
    <section class="section" style="background:#FFF9F6; padding:80px 5%; margin:60px 0;">
        <div style="text-align:center; margin-bottom:44px;">
            <h2 style="font-size:28px; font-weight:800; color:#111;">Mengapa Memasak Bersama Kami?</h2>
            <p style="color:var(--text-m); margin-top:8px; font-size:14px;">Platform kami dirancang untuk memudahkanmu jadi chef di rumah sendiri dengan teknologi tercanggih.</p>
        </div>
        <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:20px;">
            @foreach([
                ['fas fa-brain', 'AI Recommendation', 'Dapatkan saran resep yang dipelajari dari seleramu setiap hari.', '#FF5A36'],
                ['fas fa-comments', 'Komunitas Aktif', 'Saling berbagi rating, foto masakan, dan tips rahasia dengan sesama member.', '#2E7D32'],
                ['fas fa-video', 'Video VIP Eksklusif', 'Akses tutorial video 4K dengan teknik masak tingkat lanjut.', '#7B1FA2'],
                ['fas fa-user-tie', 'Chef Konsultasi', 'Chat langsung dengan Chef profesional untuk tanya jawab masakanmu.', '#1565C0']
            ] as [$icon, $title, $desc, $color])
            <div class="trending-big-card" style="padding:28px; text-align:center; background:#FFF;">
                <div style="width:50px; height:50px; border-radius:12px; background:{{ $color }}10; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:{{ $color }}; font-size:20px;">
                    <i class="{{ $icon }}"></i>
                </div>
                <h4 style="font-size:15px; font-weight:800; color:#111; margin-bottom:8px;">{{ $title }}</h4>
                <p style="font-size:12px; color:var(--text-m); line-height:1.6;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Upgrade to VIP Banner -->
    <section class="section">
        <div class="upgrade-banner">
            <div>
                <span style="font-size:10px; font-weight:800; background:rgba(255,255,255,0.2); padding:4px 12px; border-radius:20px; letter-spacing:0.5px;">LIMITED OFFER</span>
                <h2 style="font-size:36px; font-weight:800; margin:16px 0 10px 0; line-height:1.2;">Upgrade ke Paket VIP<br>& Masak Lebih Pro</h2>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:10px; font-size:13px; margin-top:20px; opacity:0.9;">
                    <li><i class="fas fa-check-circle"></i> Bebas Iklan Selamanya</li>
                    <li><i class="fas fa-check-circle"></i> Download Resep Offline PDF</li>
                    <li><i class="fas fa-check-circle"></i> Akses 1000+ Video Masterclass</li>
                    <li><i class="fas fa-check-circle"></i> Prioritas Support Chef 24/7</li>
                </ul>
            </div>
            
            <div class="upgrade-price-card">
                <p style="font-size:11px; font-weight:700; color:#999; text-transform:uppercase;">Paket Bulanan</p>
                <div style="margin:16px 0 6px 0;">
                    <span style="font-size:16px; font-weight:800; color:#333; vertical-align:super;">Rp</span>
                    <strong style="font-size:42px; font-weight:800; color:#111;">49k</strong>
                    <span style="font-size:14px; color:#777;">/bulan</span>
                </div>
                <p style="font-size:11px; color:#aaa; text-decoration:line-through; margin-bottom:24px;">*Penawaran terbatas Rp 129.000</p>
                <a href="{{ route('vip.index') }}" class="btn" style="width:100%; padding:12px; border-radius:25px; background:var(--primary); color:#FFF; font-weight:700; display:flex; justify-content:center;">Mulai Membership VIP</a>
                <span style="font-size:10px; color:#aaa; display:block; margin-top:12px;"><i class="fas fa-lock"></i> Aman & Terenkripsi 256-bit SSL</span>
            </div>
        </div>
    </section>

@else

    <!-- ────────────────────────────────────────────────────────
         🛡️ AUTHENTICATED USER DASHBOARD (Dashboard User - RasaRekomendasi v2)
         ──────────────────────────────────────────────────────── -->
    <div class="dashboard-container">
        <!-- Sidebar Kiri -->
        <aside class="dash-sidebar">
            <ul class="dash-menu">
                <li><a href="{{ route('welcome') }}" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="{{ route('recipes.index') }}"><i class="fas fa-book-open"></i> Recipes</a></li>
                <li><a href="{{ route('recipes.index') }}"><i class="fas fa-folder-open"></i> Categories</a></li>
                <li><a href="{{ route('consultations.index') }}"><i class="fas fa-comments"></i> Chat</a></li>
                <li><a href="{{ route('profile.edit') }}"><i class="fas fa-chart-line"></i> Statistics</a></li>
            </ul>
            <div style="padding: 0 20px;">
                <div style="background:#FFF8F6; border:1px solid #FFE0D8; border-radius:12px; padding:16px; text-align:center;">
                    <i class="fas fa-headset" style="color:var(--primary); font-size:20px; margin-bottom:8px;"></i>
                    <h5 style="font-size:12px; font-weight:800; color:#111;">Butuh Bantuan?</h5>
                    <p style="font-size:10px; color:#777; margin-top:2px;">Hubungi Chef Support kapan pun dibutuhkan.</p>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="dash-main">
            <!-- Orange Welcome Banner -->
            <div class="welcome-banner">
                <div style="z-index:2;">
                    <h2 style="font-size:26px; font-weight:800; line-height:1.2; font-family:'Outfit',sans-serif">Good Morning, Chef!<br>Halo, {{ Auth::user()->name }} 🍳</h2>
                    
                    @if(Auth::user()->hasActiveVip())
                        <div class="vip-pill">
                            <i class="fas fa-crown" style="color:#FFD700"></i> VIP MEMBER Expiry: Dec 31, 2024
                        </div>
                    @else
                        <div class="vip-pill">
                            <i class="fas fa-star" style="color:#FFA500"></i> Regular Tier Member
                        </div>
                    @endif
                </div>

                <div style="z-index:2;">
                    <a href="{{ route('vip.index') }}" class="btn" style="background:#FFF; color:#FF5A36; font-weight:700; border-radius:24px; padding:10px 24px;">Upgrade Tier</a>
                </div>
                <!-- Background visual accent -->
                <div style="position:absolute; right:-40px; top:-20px; width:220px; height:220px; background:rgba(255,255,255,0.1); border-radius:50%; z-index:1;"></div>
            </div>

            <!-- Five Circular Icon Tiles row -->
            <div class="tiles-row">
                <!-- Tile 1 -->
                <div class="tile-card" onclick="window.location='{{ route('recommendations.index') }}'">
                    <div class="tile-icon" style="background:#FFF0EC; color:#FF5A36;"><i class="fas fa-magic"></i></div>
                    <span style="font-size:12px; font-weight:700; color:#333;">Recommend</span>
                </div>
                <!-- Tile 2 -->
                <div class="tile-card" onclick="window.location='{{ route('vip.index') }}'">
                    <div class="tile-icon" style="background:#EBF3FF; color:#1565C0;"><i class="fas fa-receipt"></i></div>
                    <span style="font-size:12px; font-weight:700; color:#333;">Transactions</span>
                </div>
                <!-- Tile 3 -->
                <div class="tile-card" onclick="window.location='{{ route('consultations.index') }}'">
                    <div class="tile-icon" style="background:#E8F5E9; color:#2E7D32;"><i class="far fa-calendar-check"></i></div>
                    <span style="font-size:12px; font-weight:700; color:#333;">Chef Schedule</span>
                </div>
                <!-- Tile 4 -->
                <div class="tile-card" onclick="window.location='{{ route('consultations.index') }}'">
                    <div class="tile-icon" style="background:#F3E5F5; color:#7B1FA2;"><i class="far fa-comments"></i></div>
                    <span style="font-size:12px; font-weight:700; color:#333;">Chef Chat</span>
                </div>
                <!-- Tile 5 -->
                <div class="tile-card" onclick="window.location='{{ route('vip.index') }}'">
                    <div class="tile-icon" style="background:#FFF9EF; color:#FF9800;"><i class="fas fa-video"></i></div>
                    <span style="font-size:12px; font-weight:700; color:#333;">VIP Videos</span>
                </div>
            </div>

            <!-- Content Split Row -->
            <div class="dashboard-split">
                <!-- Left (2fr): Recommended for You -->
                <div class="white-card" style="border-radius:20px; padding:26px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                        <h3 style="font-size:18px; font-weight:800; color:#111;">Recommended for You</h3>
                        <a href="{{ route('recipes.index') }}" style="color:var(--primary); font-size:13px; font-weight:700;">See All</a>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <!-- Recipe 1 -->
                        <div class="recipe-card-modern" style="position:relative;">
                            <img src="https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=400&q=80" alt="">
                            <span class="recipe-tag-pill" style="background:#2E7D32;">Healthy</span>
                            <button class="heart-float"><i class="fas fa-heart"></i></button>
                            <div style="padding:16px;">
                                <h4 style="font-size:14px; font-weight:800; color:#111;">Modern Gyudon Beef Bowl</h4>
                                <div style="display:flex; gap:10px; font-size:11px; color:#777; margin-top:8px; font-weight:600;">
                                    <span><i class="far fa-clock"></i> 15m</span>
                                    <span>•</span>
                                    <span>450 kcal</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recipe 2 -->
                        <div class="recipe-card-modern" style="position:relative;">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&q=80" alt="">
                            <span class="recipe-tag-pill" style="background:#FF9800;">Vegan</span>
                            <button class="heart-float"><i class="fas fa-heart"></i></button>
                            <div style="padding:16px;">
                                <h4 style="font-size:14px; font-weight:800; color:#111;">Zesty Summer Quinoa Salad</h4>
                                <div style="display:flex; gap:10px; font-size:11px; color:#777; margin-top:8px; font-weight:600;">
                                    <span><i class="far fa-clock"></i> 10m</span>
                                    <span>•</span>
                                    <span>320 kcal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right (1fr): Recent Activity Feed -->
                <div class="white-card" style="border-radius:20px; padding:26px; display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <h3 style="font-size:16px; font-weight:800; color:#111; margin-bottom:20px;">Recent Activity</h3>
                        
                        <div style="display:flex; flex-direction:column;">
                            <!-- Activity 1 -->
                            <div class="activity-item">
                                <img src="https://i.pravatar.cc/80?img=33" class="activity-avatar" alt="">
                                <div>
                                    <div style="font-size:12px; font-weight:800; color:#111;">Chef Marco <span style="font-weight:500; color:#777;">left a comment</span></div>
                                    <p style="font-size:11px; color:#555; margin-top:2px; line-height:1.4;">"Great job on that Rendang! Try adding more star anise next time for more aroma."</p>
                                    <span style="font-size:9px; color:#bbb; display:block; margin-top:4px;">2 hours ago</span>
                                </div>
                            </div>

                            <!-- Activity 2 -->
                            <div class="activity-item">
                                <div style="width:36px; height:36px; border-radius:50%; background:#FFF4E0; color:#FF9800; display:flex; align-items:center; justify-content:center; font-size:14px;"><i class="fas fa-star"></i></div>
                                <div>
                                    <div style="font-size:12px; font-weight:800; color:#111;">Rating Received <span style="font-weight:500; color:#777;">on Pasta Carbonara</span></div>
                                    <div style="color:#FFA500; font-size:10px; margin-top:2px;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                    <span style="font-size:9px; color:#bbb; display:block; margin-top:4px;">Yesterday</span>
                                </div>
                            </div>

                            <!-- Activity 3 -->
                            <div class="activity-item">
                                <img src="https://i.pravatar.cc/80?img=47" class="activity-avatar" alt="">
                                <div>
                                    <div style="font-size:12px; font-weight:800; color:#111;">Sarah Kitchen <span style="font-weight:500; color:#777;">replied to you</span></div>
                                    <p style="font-size:11px; color:#555; margin-top:2px; line-height:1.4;">"Where did you buy the truffle oil? Looks so delicious!"</p>
                                    <span style="font-size:9px; color:#bbb; display:block; margin-top:4px;">2 days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button style="width:100%; height:38px; border:1px solid #FF5A36; background:transparent; color:#FF5A36; border-radius:10px; font-family:inherit; font-weight:700; font-size:11px; cursor:pointer; margin-top:20px;">VIEW MORE ACTIVITY</button>
                </div>
            </div>
        </main>
    </div>
@endguest

@endsection
