@extends('layouts.app')

@section('title', 'Beranda')
@section('description', 'Temukan ribuan resep masakan Indonesia autentik dengan rekomendasi personal dan konsultasi chef profesional.')

@push('styles')
<style>
    /* ── Hero ── */
    .hero {
        min-height: 92vh;
        display: flex; align-items: center;
        position: relative; overflow: hidden;
        padding: 4rem 2rem;
        background: linear-gradient(0deg, #FCF9F8, #FCF9F8), #FFFFFF;
    }
    .hero-bg {
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 80% 60% at 70% 40%, rgba(224,92,0,.08) 0%, transparent 60%),
            radial-gradient(ellipse 60% 80% at 20% 70%, rgba(247,201,72,.04) 0%, transparent 50%);
    }
    .hero-grid {
        position: absolute; inset: 0; opacity: .04;
        background-image: linear-gradient(var(--border) 1px, transparent 1px),
                          linear-gradient(90deg, var(--border) 1px, transparent 1px);
        background-size: 50px 50px;
    }
    .hero-inner {
        position: relative; max-width: 1280px; margin: 0 auto; width: 100%;
        display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;
    }
    .hero-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        background: rgba(224,92,0,.15); border: 1px solid rgba(224,92,0,.3);
        color: var(--primary-l); padding: .4rem 1rem;
        border-radius: 50px; font-size: .8rem; font-weight: 600;
        margin-bottom: 1.5rem; letter-spacing: .05em;
    }
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700; line-height: 1.15;
        margin-bottom: 1.25rem;
    }
    .hero-title .highlight {
        background: linear-gradient(135deg, var(--primary-l), var(--accent));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hero-desc { font-size: 1.05rem; color: var(--text-muted); margin-bottom: 2rem; max-width: 480px; }
    .hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; }

    .hero-stats {
        display: flex; gap: 2rem; margin-top: 3rem;
        padding-top: 2rem; border-top: 1px solid var(--border);
    }
    .stat-item h3 { font-size: 1.8rem; font-weight: 800; color: var(--primary-l); }
    .stat-item p { font-size: .8rem; color: var(--text-muted); font-weight: 500; }

    /* ── Recipe Card Stack ── */
    .hero-visual { position: relative; height: 480px; }
    .recipe-stack {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .recipe-card-float {
        position: absolute;
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.5);
        transition: transform .3s ease;
    }
    .recipe-card-float:nth-child(1) {
        width: 240px; transform: rotate(-6deg) translateX(-60px) translateY(20px);
        opacity: .6;
    }
    .recipe-card-float:nth-child(2) {
        width: 260px; z-index: 2;
        transform: rotate(0deg);
    }
    .recipe-card-float:nth-child(3) {
        width: 230px; transform: rotate(5deg) translateX(55px) translateY(10px);
        opacity: .6;
    }
    .recipe-card-float:hover { transform: rotate(0deg) translateY(-8px) !important; opacity: 1 !important; z-index: 10; }
    .recipe-card-float img { width: 100%; height: 160px; object-fit: cover; }
    .recipe-card-float .rc-body { padding: 1rem; }
    .recipe-card-float .rc-tag {
        font-size: .7rem; color: var(--primary-l); font-weight: 700;
        text-transform: uppercase; letter-spacing: .05em;
    }
    .recipe-card-float .rc-title { font-size: .95rem; font-weight: 700; margin: .25rem 0; }
    .recipe-card-float .rc-meta { font-size: .75rem; color: var(--text-muted); display: flex; gap: 1rem; }

    /* ── Sections ── */
    .section { 
        padding: 5rem 2rem;
        background: linear-gradient(0deg, #FCF9F8, #FCF9F8), #FFFFFF;
    }
    .section-inner { max-width: 1280px; margin: 0 auto; }
    .section-header { margin-bottom: 2.5rem; }
    .section-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 700;
        margin-bottom: .5rem;
    }
    .section-header p { color: var(--text-muted); }

    /* ── Feature Cards ── */
    .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .feature-card {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 2rem;
        transition: border-color .3s, transform .3s;
        position: relative; overflow: hidden;
    }
    .feature-card::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(circle at 30% 30%, rgba(224,92,0,.08), transparent 60%);
        opacity: 0; transition: opacity .3s;
    }
    .feature-card:hover { border-color: rgba(224,92,0,.3); transform: translateY(-4px); }
    .feature-card:hover::before { opacity: 1; }
    .feature-icon {
        width: 52px; height: 52px; border-radius: var(--radius-sm);
        background: rgba(224,92,0,.12); border: 1px solid rgba(224,92,0,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; margin-bottom: 1.25rem; color: var(--primary-l);
    }
    .feature-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: .5rem; }
    .feature-card p { font-size: .875rem; color: var(--text-muted); line-height: 1.7; }

    /* ── Recipe Grid ── */
    .recipe-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
    .rcard {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        transition: transform .25s, box-shadow .25s;
        position: relative;
    }
    .rcard:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.5); }
    .rcard-img { width: 100%; height: 200px; object-fit: cover; background: var(--dark-3); }
    .rcard-body { padding: 1.25rem; }
    .rcard-category { font-size: .7rem; font-weight: 700; color: var(--primary-l); text-transform: uppercase; letter-spacing: .08em; margin-bottom: .5rem; }
    .rcard-title { font-size: 1rem; font-weight: 700; margin-bottom: .5rem; line-height: 1.4; }
    .rcard-desc { font-size: .8rem; color: var(--text-muted); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .rcard-meta { display: flex; gap: 1rem; margin-top: .85rem; font-size: .75rem; color: var(--text-muted); }
    .rcard-meta span { display: flex; align-items: center; gap: .3rem; }
    .vip-badge {
        position: absolute; top: .75rem; right: .75rem;
        background: var(--accent); color: #000;
        font-size: .65rem; font-weight: 800; letter-spacing: .05em;
        padding: .2rem .55rem; border-radius: 50px;
        text-transform: uppercase;
    }

    /* ── CTA ── */
    .cta-section {
        margin: 0 2rem 3rem; border-radius: var(--radius);
        background: linear-gradient(135deg, rgba(224,92,0,.15), rgba(247,201,72,.08));
        border: 1px solid rgba(224,92,0,.2);
        padding: 4rem 3rem; text-align: center;
    }
    .cta-section h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 1rem; }
    .cta-section p { color: var(--text-muted); margin-bottom: 2rem; font-size: 1.05rem; }

    @media (max-width: 768px) {
        .hero-inner { grid-template-columns: 1fr; }
        .hero-visual { display: none; }
        .features-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-inner">
        <div class="hero-text">
            <div class="hero-badge">
                <i class="fas fa-fire"></i> Platform Resep #1 Indonesia
            </div>
            <h1 class="hero-title">
                Temukan Resep<br>
                <span class="highlight">Terbaik Untukmu</span>
            </h1>
            <p class="hero-desc">
                Dapatkan rekomendasi resep personal berdasarkan selera dan kebutuhan nutrisimu.
                Konsultasikan masalah masak dengan chef profesional kami.
            </p>
            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-utensils"></i> Mulai Memasak
                </a>
                <a href="#fitur" class="btn btn-outline">
                    <i class="fas fa-play-circle"></i> Pelajari Lebih
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Resep Tersedia</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Chef Profesional</p>
                </div>
                <div class="stat-item">
                    <h3>10rb+</h3>
                    <p>Pengguna Aktif</p>
                </div>
            </div>
        </div>

        {{-- Floating recipe cards --}}
        <div class="hero-visual">
            <div class="recipe-stack">
                <div class="recipe-card-float">
                    <img src="https://images.unsplash.com/photo-1574484284002-952d92456975?w=300&q=80" alt="Rendang">
                    <div class="rc-body">
                        <div class="rc-tag">🇮🇩 Indonesia</div>
                        <div class="rc-title">Rendang Padang</div>
                        <div class="rc-meta">
                            <span><i class="fas fa-clock"></i> 4j</span>
                            <span><i class="fas fa-star" style="color:var(--accent)"></i> 4.9</span>
                        </div>
                    </div>
                </div>
                <div class="recipe-card-float">
                    <img src="https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=300&q=80" alt="Ramen">
                    <div class="rc-body">
                        <div class="rc-tag">🍜 Asia</div>
                        <div class="rc-title">Ramen Tonkotsu</div>
                        <div class="rc-meta">
                            <span><i class="fas fa-clock"></i> 13j</span>
                            <span><i class="fas fa-star" style="color:var(--accent)"></i> 4.8</span>
                        </div>
                    </div>
                </div>
                <div class="recipe-card-float">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300&q=80" alt="Smoothie">
                    <div class="rc-body">
                        <div class="rc-tag">🥗 Sehat</div>
                        <div class="rc-title">Smoothie Bowl</div>
                        <div class="rc-meta">
                            <span><i class="fas fa-clock"></i> 10m</span>
                            <span><i class="fas fa-star" style="color:var(--accent)"></i> 4.7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Fitur ── --}}
<section class="section" id="fitur">
    <div class="section-inner">
        <div class="section-header">
            <h2>Kenapa RasaRekomendasi?</h2>
            <p>Fitur canggih yang menjadikan pengalaman masak lebih menyenangkan</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-brain"></i></div>
                <h3>Rekomendasi Cerdas</h3>
                <p>Sistem AI kami mempelajari selera dan preferensi diet kamu untuk memberikan rekomendasi resep yang paling relevan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-comments"></i></div>
                <h3>Konsultasi Chef</h3>
                <p>Chat langsung dengan chef profesional bersertifikat untuk mendapatkan tips, teknik, dan solusi masak terbaik.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-crown"></i></div>
                <h3>Konten VIP Eksklusif</h3>
                <p>Akses ribuan resep premium dengan video tutorial HD dari chef berbintang hanya dengan berlangganan VIP.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-bookmark"></i></div>
                <h3>Simpan Favorit</h3>
                <p>Buat koleksi resep favoritmu dan akses kapan saja, bahkan saat offline. Organisir berdasarkan kategori.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-leaf"></i></div>
                <h3>Info Nutrisi Detail</h3>
                <p>Pantau asupan kalori, protein, karbohidrat, dan nutrisi lainnya untuk menjaga gaya hidup sehat.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-star"></i></div>
                <h3>Ulasan Komunitas</h3>
                <p>Baca ulasan jujur dari jutaan pengguna dan bagikan pengalaman masakmu untuk membantu sesama.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── Resep Populer ── --}}
<section class="section" style="padding-top:0">
    <div class="section-inner">
        <div class="section-header" style="display:flex;justify-content:space-between;align-items:flex-end">
            <div>
                <h2>Resep Terpopuler</h2>
                <p>Disukai ribuan pengguna setiap harinya</p>
            </div>
            <a href="{{ route('login') }}" class="btn btn-outline" style="white-space:nowrap">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="recipe-grid">
            @php
                $popularRecipes = \App\Models\Recipe::published()->popular()->take(6)->with('chef','category')->get();
            @endphp
            @foreach($popularRecipes as $recipe)
            <div class="rcard">
                @if($recipe->is_vip_content)
                    <span class="vip-badge"><i class="fas fa-crown"></i> VIP</span>
                @endif
                <img class="rcard-img"
                     src="{{ $recipe->image_url }}"
                     alt="{{ $recipe->title }}">
                <div class="rcard-body">
                    <div class="rcard-category">{{ $recipe->category->name ?? 'Resep' }}</div>
                    <div class="rcard-title">{{ $recipe->title }}</div>
                    <div class="rcard-desc">{{ $recipe->description }}</div>
                    <div class="rcard-meta">
                        <span><i class="fas fa-clock" style="color:var(--primary-l)"></i> {{ $recipe->total_time }} menit</span>
                        <span><i class="fas fa-fire" style="color:var(--accent)"></i> {{ $recipe->calories }} kal</span>
                        <span><i class="fas fa-signal" style="color:var(--text-muted)"></i> {{ $recipe->difficulty_label }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<div class="cta-section">
    <h2>Siap Mulai Memasak?</h2>
    <p>Bergabung dengan ribuan pengguna dan temukan resep impianmu hari ini. Gratis!</p>
    <a href="{{ route('login') }}" class="btn btn-primary" style="font-size:1rem;padding:.75rem 2rem">
        <i class="fas fa-utensils"></i> Mulai Sekarang — Gratis
    </a>
</div>

@endsection
