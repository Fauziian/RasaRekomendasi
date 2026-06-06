@extends('layouts.app')
@section('title', 'Jelajah Resep Kuliner')
@section('content')
<div class="page-padding">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:30px;">
        <div>
            <h1 style="font-size:32px;font-weight:800;color:#111;">Daftar Resep Pilihan</h1>
            <p style="color:var(--text-m);font-size:15px;margin-top:4px;">Temukan resep andalan kreasi chef profesional terbaik.</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:250px 1fr;gap:30px;">
        {{-- Filters Left --}}
        <aside>
            <form method="GET" action="{{ route('recipes.index') }}" style="display:flex;flex-direction:column;gap:20px;">
                <div class="card" style="padding:20px;display:flex;flex-direction:column;gap:15px;">
                    <h3 style="font-size:16px;font-weight:700;">Filter Masakan</h3>
                    
                    {{-- Search --}}
                    <div>
                        <label class="form-label" style="font-size:11px;">CARI KATA KUNCI</label>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari resep..." class="form-control" style="padding:8px 12px;">
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="form-label" style="font-size:11px;">KATEGORI</label>
                        <select name="category" class="form-control" style="padding:8px 12px;">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Difficulty --}}
                    <div>
                        <label class="form-label" style="font-size:11px;">TINGKAT KESULITAN</label>
                        <select name="difficulty" class="form-control" style="padding:8px 12px;">
                            <option value="">Semua Level</option>
                            <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Mudah</option>
                            <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm" style="width:100%;justify-content:center;">Terapkan Filter</button>
                    <a href="{{ route('recipes.index') }}" class="btn btn-white btn-sm" style="width:100%;justify-content:center;font-size:12px;">Reset Filter</a>
                </div>
            </form>
        </aside>

        {{-- Recipes Grid --}}
        <div>
            @guest
            <div style="background:linear-gradient(135deg,#FFF5F2,#FFF); border:1.5px solid #FFD6C8; border-radius:14px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:12px;">
                <i class="fas fa-lock" style="color:#FF5A36; font-size:18px;"></i>
                <div>
                    <strong style="font-size:13px; color:#111;">Login untuk membuka resep lengkap</strong>
                    <span style="font-size:12px; color:#777; margin-left:8px;">Kamu bisa menjelajah daftar resep, tapi perlu login untuk melihat detail & langkah memasak.</span>
                    <a href="{{ route('login') }}" style="color:var(--primary); font-weight:700; font-size:12px; margin-left:8px;">Masuk sekarang &rsaquo;</a>
                </div>
            </div>
            @endguest

            <div class="grid-3" style="margin-bottom:30px;">
                @forelse($recipes as $recipe)
                @auth
                <a href="{{ route('recipes.show', $recipe->slug) }}" style="text-decoration:none;color:inherit;display:block;">
                @else
                <a href="{{ route('login') }}" style="text-decoration:none;color:inherit;display:block;" title="Login untuk melihat resep ini">
                @endauth
                    <div class="recipe-card" style="position:relative;">
                        <div class="recipe-card-img" style="background-image: url('{{ $recipe->image_url }}');">
                            @if($recipe->is_vip_content)
                                <div class="vip-lock"><i class="fas fa-crown"></i> VIP</div>
                            @endif
                            @guest
                            <div style="position:absolute; inset:0; background:rgba(0,0,0,0.08); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.2s;" class="recipe-login-overlay">
                                <span style="background:rgba(0,0,0,0.65); color:#FFF; font-size:11px; font-weight:700; padding:6px 14px; border-radius:20px;"><i class="fas fa-lock"></i> Login untuk Lihat</span>
                            </div>
                            @endguest
                        </div>
                        <div class="recipe-card-content">
                            <div class="recipe-card-meta">
                                <span class="meta-tag hot">{{ strtoupper($recipe->difficulty_label) }}</span>
                                <span class="meta-tag"><i class="far fa-clock"></i> {{ $recipe->total_time }} min</span>
                            </div>
                            <h3>{{ $recipe->title }}</h3>
                            <div class="recipe-author">
                                <img src="{{ $recipe->chef->avatar_url ?? 'https://ui-avatars.com/api/?name=Chef&size=40' }}" alt="">
                                <span>by {{ $recipe->chef->name ?? 'Chef' }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div style="grid-column: span 3; text-align:center; padding:60px 0; color:var(--text-m);">
                    <i class="fas fa-utensils" style="font-size:40px;color:#ccc;margin-bottom:15px;display:block;"></i>
                    Resep tidak ditemukan. Coba filter atau kata kunci lainnya!
                </div>
                @endforelse
            </div>
            {{ $recipes->links() }}
        </div>
    </div>
</div>
@endsection
