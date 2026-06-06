@extends('layouts.app')
@section('title', 'Resep Favorit Saya')
@section('content')
<div class="page-padding">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:30px; border-bottom: 1px solid #EEE; padding-bottom: 15px;">
        <div>
            <h1 style="font-size:32px;font-weight:800;color:#111; display:flex; align-items:center; gap:12px;">
                <i class="fas fa-heart" style="color:#FF5A36;"></i> Resep Favorit Saya
            </h1>
            <p style="color:var(--text-m);font-size:15px;margin-top:4px;">Koleksi resep masakan yang Anda simpan untuk dicoba nanti.</p>
        </div>
        <a href="{{ route('recipes.index') }}" class="btn btn-white btn-sm" style="font-weight:700;">
            <i class="fas fa-search"></i> Cari Resep Baru
        </a>
    </div>

    @if($recipes->isEmpty())
        <div style="text-align:center; padding:80px 20px; background:#FFF; border: 1px solid #EAE6DF; border-radius:20px; max-width: 600px; margin: 40px auto;">
            <div style="width:70px; height:70px; border-radius:50%; background:#FFF0EC; color:#FF5A36; display:flex; align-items:center; justify-content:center; font-size:28px; margin: 0 auto 20px;">
                <i class="far fa-heart"></i>
            </div>
            <h3 style="font-size:20px; font-weight:800; color:#111; margin-bottom:8px;">Belum Ada Resep Favorit</h3>
            <p style="color:#777; font-size:14px; line-height:1.6; margin-bottom:24px;">
                Jelajahi resep masakan lezat kreasi chef profesional kami, simpan resep favorit Anda dengan menekan ikon hati untuk menyimpannya di sini.
            </p>
            <a href="{{ route('recipes.index') }}" class="btn btn-primary">
                Mulai Jelajah Resep
            </a>
        </div>
    @else
        <div class="grid-4" style="margin-bottom:30px;">
            @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe->slug) }}" style="text-decoration:none;color:inherit;display:block;">
                    <div class="recipe-card" style="position:relative; height:100%; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div class="recipe-card-img" style="background-image: url('{{ $recipe->image_url }}');">
                                @if($recipe->is_vip_content)
                                    <div class="vip-lock"><i class="fas fa-crown"></i> VIP</div>
                                @endif
                            </div>
                            <div class="recipe-card-content">
                                <div class="recipe-card-meta">
                                    <span class="meta-tag hot">{{ strtoupper($recipe->difficulty_label) }}</span>
                                    <span class="meta-tag"><i class="far fa-clock"></i> {{ $recipe->total_time }} min</span>
                                </div>
                                <h3 style="font-size: 16px; margin: 10px 0;">{{ $recipe->title }}</h3>
                            </div>
                        </div>
                        <div class="recipe-card-content" style="padding-top:0; border-top:none;">
                            <div class="recipe-author" style="margin-top:0;">
                                <img src="{{ $recipe->chef->avatar_url ?? 'https://ui-avatars.com/api/?name=Chef&size=40' }}" alt="">
                                <span style="font-size:11px;">by {{ $recipe->chef->name ?? 'Chef' }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        {{ $recipes->links() }}
    @endif
</div>
@endsection
