@extends('layouts.app')
@section('title', 'Rekomendasi Resep')

@push('styles')
<style>
    .rec-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 28px;
        max-width: 1280px;
        margin: 36px auto;
        padding: 0 20px;
        align-items: start;
    }

    /* ── Sidebar ─────────────────────────────────────────── */
    .rec-sidebar {
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 20px;
        padding: 24px;
        position: sticky;
        top: 86px;
    }
    .sidebar-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 16px;
        border-bottom: 1px solid #F0EDE8;
        margin-bottom: 20px;
    }
    .sidebar-head h3 { font-size: 16px; font-weight: 800; color: #111; margin: 0; }

    .filter-sec { margin-bottom: 22px; }
    .filter-sec h4 {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #888;
        margin: 0 0 12px;
    }

    /* Difficulty pills */
    .diff-pills { display: flex; gap: 8px; }
    .diff-btn {
        flex: 1;
        padding: 8px 4px;
        border-radius: 20px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        border: 1.5px solid #E8E3DB;
        background: #FFF;
        color: #555;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: block;
        transition: all .2s;
    }
    .diff-btn:hover { border-color: #A03010; color: #A03010; }
    .diff-btn.active { background: #A03010; border-color: #A03010; color: #FFF; }

    /* Time radio rows */
    .time-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 10px;
        cursor: pointer;
    }
    .time-row input { accent-color: #A03010; width: 16px; height: 16px; cursor: pointer; }

    /* Category checkboxes */
    .cat-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 10px;
        cursor: pointer;
    }
    .cat-row input { accent-color: #A03010; width: 16px; height: 16px; cursor: pointer; }

    .apply-btn {
        display: block;
        width: 100%;
        padding: 12px;
        border-radius: 14px;
        background: linear-gradient(135deg, #E05528, #A03010);
        color: #FFF;
        font-family: inherit;
        font-size: 13px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        margin-top: 4px;
        transition: opacity .2s;
    }
    .apply-btn:hover { opacity: .88; }

    .reset-link {
        display: block;
        text-align: center;
        margin-top: 10px;
        font-size: 12px;
        color: #999;
        text-decoration: none;
    }
    .reset-link:hover { color: #A03010; }

    /* ── Recipe Cards ────────────────────────────────────── */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .rc {
        background: #FFF;
        border-radius: 18px;
        border: 1px solid #EAE6DF;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform .2s, box-shadow .2s;
    }
    .rc:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,.08); }

    .rc-img {
        position: relative;
        height: 190px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .rc-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s;
    }
    .rc:hover .rc-img img { transform: scale(1.05); }

    .pct-badge {
        position: absolute;
        top: 11px; left: 11px;
        background: rgba(46,125,50,.9);
        color: #FFF;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 11px;
        border-radius: 20px;
    }

    /* Heart button */
    .heart-btn {
        position: absolute;
        top: 11px; right: 11px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,.95);
        border: 1px solid #EEE;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        color: #ccc;
        transition: all .2s;
    }
    .heart-btn:hover, .heart-btn.saved { color: #E53935; border-color: #FFCDD2; background: #FFF; }
    .heart-btn.saved i { font-weight: 900; }

    .vip-lock-badge {
        position: absolute;
        bottom: 11px; right: 11px;
        background: rgba(245,127,23,.9);
        color: #FFF;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 9px;
        border-radius: 20px;
    }

    .rc-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .rc-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }
    .rc-cat { font-size: 10px; font-weight: 800; color: #A03010; text-transform: uppercase; letter-spacing: .4px; }
    .rc-rating { font-size: 12px; font-weight: 800; color: #FFA500; }
    .rc-title { font-size: 14px; font-weight: 800; color: #111; line-height: 1.3; margin: 0 0 6px; }
    .rc-desc { font-size: 12px; color: #888; line-height: 1.5; flex-grow: 1; margin: 0 0 12px; }
    .rc-footer {
        display: flex;
        gap: 10px;
        font-size: 11px;
        font-weight: 600;
        color: #999;
        padding-top: 10px;
        border-top: 1px solid #F5F3EF;
        margin-bottom: 12px;
    }
    .btn-lihat {
        display: block;
        width: 100%;
        padding: 10px;
        border-radius: 30px;
        background: #A03010;
        color: #FFF;
        font-weight: 700;
        font-size: 12px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: .5px;
        transition: background .2s;
    }
    .btn-lihat:hover { background: #802008; }

    /* Empty state */
    .empty-rec {
        grid-column: 1/-1;
        text-align: center;
        padding: 60px 20px;
        color: #aaa;
    }
    .empty-rec i { font-size: 44px; margin-bottom: 14px; display: block; opacity: .35; }
    .empty-rec h3 { font-size: 17px; font-weight: 700; color: #666; margin-bottom: 6px; }

    /* Toast */
    #toast {
        position: fixed;
        bottom: 28px; right: 28px;
        background: #222;
        color: #FFF;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        opacity: 0;
        transform: translateY(12px);
        transition: all .3s;
        z-index: 9999;
        pointer-events: none;
    }
    #toast.show { opacity: 1; transform: translateY(0); }

    @media (max-width: 960px) { .rec-layout { grid-template-columns: 1fr; } .rec-sidebar { position: static; } }
    @media (max-width: 640px) { .cards-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 420px) { .cards-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

{{-- Toast notification --}}
<div id="toast"></div>

<div class="rec-layout">

    {{-- ── SIDEBAR FILTER ───────────────────────────────── --}}
    <aside class="rec-sidebar">
        <div class="sidebar-head">
            <h3>Filter</h3>
            <a href="{{ route('recommendations.results') }}" style="font-size:12px; font-weight:700; color:#A03010; text-decoration:none;">Reset</a>
        </div>

        <form method="GET" action="{{ route('recommendations.results') }}" id="filterForm">

            {{-- Difficulty ─────────────────────────────── --}}
            <div class="filter-sec">
                <h4>Kesulitan</h4>
                <div class="diff-pills">
                    <a href="{{ route('recommendations.results', array_merge(request()->except('difficulty','page'), ['difficulty'=>'easy'])) }}"
                       class="diff-btn {{ request('difficulty') == 'easy' ? 'active' : '' }}">Mudah</a>
                    <a href="{{ route('recommendations.results', array_merge(request()->except('difficulty','page'), ['difficulty'=>'medium'])) }}"
                       class="diff-btn {{ request('difficulty') == 'medium' ? 'active' : '' }}">Sedang</a>
                    <a href="{{ route('recommendations.results', array_merge(request()->except('difficulty','page'), ['difficulty'=>'hard'])) }}"
                       class="diff-btn {{ request('difficulty') == 'hard' ? 'active' : '' }}">Sulit</a>
                </div>
            </div>

            {{-- Max Time ────────────────────────────────── --}}
            <div class="filter-sec">
                <h4>Waktu Memasak</h4>
                @foreach([15 => '< 15 menit', 30 => '< 30 menit', 60 => '< 60 menit', 120 => '< 120 menit'] as $val => $lbl)
                <label class="time-row">
                    <input type="radio" name="max_time" value="{{ $val }}"
                        {{ request('max_time') == $val ? 'checked' : '' }}
                        onchange="this.form.submit()">
                    {{ $lbl }}
                </label>
                @endforeach
            </div>

            {{-- Category ────────────────────────────────── --}}
            <div class="filter-sec">
                <h4>Kategori</h4>
                @foreach($categories as $cat)
                <label class="cat-row">
                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                        {{ in_array($cat->id, (array) request('categories', [])) ? 'checked' : '' }}
                        onchange="this.form.submit()">
                    {{ $cat->name }}
                </label>
                @endforeach
            </div>

            <button type="submit" class="apply-btn">
                <i class="fas fa-search"></i> Cari Resep
            </button>
        </form>

        <a href="{{ route('recommendations.results') }}" class="reset-link">Hapus semua filter</a>
    </aside>

    {{-- ── MAIN CONTENT ─────────────────────────────────── --}}
    <main>
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:20px; flex-wrap:wrap; gap:8px;">
            <div>
                <h2 style="font-size:26px; font-weight:800; color:#111; font-family:'Outfit',sans-serif; margin:0 0 4px;">
                    Hasil Rekomendasi untuk Kamu
                </h2>
                <p style="font-size:13px; color:#888; margin:0;">
                    Ditemukan <strong>{{ $scoredRecipes->count() }}</strong> resep
                    @if(request()->hasAny(['difficulty','max_time','categories']))
                        yang cocok dengan filter
                    @endif
                </p>
            </div>
        </div>

        {{-- Active filter chips ──────────────────────────── --}}
        @if(request()->hasAny(['difficulty','max_time','categories']))
        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:20px;">
            @if(request('difficulty'))
            <span style="padding:5px 12px; background:#FFF0EC; color:#A03010; border-radius:20px; font-size:11px; font-weight:700;">
                {{ ['easy'=>'Mudah','medium'=>'Sedang','hard'=>'Sulit'][request('difficulty')] ?? request('difficulty') }}
                <a href="{{ route('recommendations.results', request()->except('difficulty')) }}" style="color:#A03010; margin-left:4px; text-decoration:none;">&times;</a>
            </span>
            @endif
            @if(request('max_time'))
            <span style="padding:5px 12px; background:#FFF0EC; color:#A03010; border-radius:20px; font-size:11px; font-weight:700;">
                &lt; {{ request('max_time') }} menit
                <a href="{{ route('recommendations.results', request()->except('max_time')) }}" style="color:#A03010; margin-left:4px; text-decoration:none;">&times;</a>
            </span>
            @endif
            @foreach($categories->whereIn('id', (array)request('categories',[])) as $ac)
            <span style="padding:5px 12px; background:#FFF0EC; color:#A03010; border-radius:20px; font-size:11px; font-weight:700;">
                {{ $ac->name }}
                <a href="{{ route('recommendations.results', array_merge(request()->except('categories'), ['categories' => array_diff((array)request('categories',[]), [$ac->id])])) }}" style="color:#A03010; margin-left:4px; text-decoration:none;">&times;</a>
            </span>
            @endforeach
            <a href="{{ route('recommendations.results') }}" style="padding:5px 12px; background:#FDECEA; color:#C0392B; border-radius:20px; font-size:11px; font-weight:700; text-decoration:none;">
                &times; Hapus Semua
            </a>
        </div>
        @endif

        {{-- Cards grid ──────────────────────────────────── --}}
        <div class="cards-grid">
            @forelse($scoredRecipes as $recipe)
            @php
                $isSaved = Auth::check() && Auth::user()->savedRecipes()->where('recipe_id', $recipe->id)->exists();
            @endphp
            <div class="rc">
                <div class="rc-img">
                    <img
                        src="{{ $recipe->image_url }}"
                        alt="{{ $recipe->title }}"
                    >
                    <span class="pct-badge">Cocok {{ $recipe->match_percent }}%</span>

                    @auth
                    <button class="heart-btn {{ $isSaved ? 'saved' : '' }}"
                            onclick="toggleSave(this, {{ $recipe->id }})"
                            title="{{ $isSaved ? 'Hapus dari favorit' : 'Simpan ke favorit' }}">
                        <i class="{{ $isSaved ? 'fas' : 'far' }} fa-heart"></i>
                    </button>
                    @endauth

                    @if($recipe->is_vip_content)
                    <span class="vip-lock-badge"><i class="fas fa-crown"></i> VIP</span>
                    @endif
                </div>

                <div class="rc-body">
                    <div class="rc-meta">
                        <span class="rc-cat">{{ $recipe->category->name ?? 'Resep' }} &bull; {{ $recipe->difficulty_label }}</span>
                        <span class="rc-rating"><i class="fas fa-star"></i> {{ number_format($recipe->rating_avg ?: 4.5, 1) }}</span>
                    </div>
                    <h3 class="rc-title">{{ $recipe->title }}</h3>
                    <p class="rc-desc">{{ Str::limit($recipe->description, 80) }}</p>
                    <div class="rc-footer">
                        <span><i class="far fa-clock"></i> {{ $recipe->total_time }} mnt</span>
                        <span>&bull;</span>
                        <span><i class="fas fa-signal"></i> {{ $recipe->difficulty_label }}</span>
                    </div>
                    <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn-lihat">Lihat Resep</a>
                </div>
            </div>
            @empty
            <div class="empty-rec">
                <i class="fas fa-search-minus"></i>
                <h3>Tidak ada resep yang cocok</h3>
                <p style="font-size:13px; margin-bottom:20px;">Coba ubah atau hapus beberapa filter.</p>
                <a href="{{ route('recommendations.results') }}"
                   style="display:inline-flex; align-items:center; gap:8px; padding:11px 24px; background:#A03010; color:#FFF; border-radius:20px; font-weight:700; font-size:13px; text-decoration:none;">
                    <i class="fas fa-undo"></i> Lihat Semua Resep
                </a>
            </div>
            @endforelse
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
// Heart/save toggle via AJAX
function toggleSave(btn, recipeId) {
    fetch('/recipes/' + recipeId + '/save', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        const icon = btn.querySelector('i');
        if (data.saved) {
            btn.classList.add('saved');
            icon.className = 'fas fa-heart';
        } else {
            btn.classList.remove('saved');
            icon.className = 'far fa-heart';
        }
        showToast(data.message);
    })
    .catch(() => showToast('Gagal menyimpan. Coba lagi.'));
}

function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}
</script>
@endpush
