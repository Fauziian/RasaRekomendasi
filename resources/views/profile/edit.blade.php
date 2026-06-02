@extends(Auth::user()->role === 'chef' ? 'layouts.chef' : (Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.app'))
@section('title', 'Profil Saya')

@push('styles')
<style>
    /* ── Hero ─────────────────────────────────────────────── */
    .profile-hero {
        background: #FAF8F5;
        border-bottom: 1px solid #EAE6DF;
        padding: 44px 5%;
    }
    .profile-hero-inner {
        display: flex;
        gap: 36px;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }
    .avatar-wrap {
        position: relative;
        width: 130px;
        height: 130px;
        flex-shrink: 0;
    }
    .avatar-wrap img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #A03010;
        box-shadow: 0 8px 24px rgba(160,48,16,.18);
    }
    .avatar-edit {
        position: absolute;
        bottom: 4px; right: 4px;
        width: 30px; height: 30px;
        background: #A03010;
        color: #FFF;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        border: 2px solid #FFF;
        cursor: pointer;
    }
    .profile-name { font-size: 30px; font-weight: 800; color: #111; font-family:'Outfit',sans-serif; margin: 0 0 4px; }
    .profile-bio  { font-size: 13px; color: #777; max-width: 560px; line-height: 1.6; margin: 8px 0 14px; }
    .profile-stats {
        display: flex; gap: 24px;
        font-size: 13px; color: #888; font-weight: 500;
    }
    .profile-stats strong { color: #111; font-weight: 800; }

    .badge-vip {
        display: inline-flex; align-items: center; gap: 5px;
        background: linear-gradient(135deg,#FFD700,#FF8C00);
        color: #5D4037;
        font-size: 11px; font-weight: 800;
        padding: 4px 12px; border-radius: 20px;
        margin-left: 10px;
    }

    /* Action buttons */
    .prof-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px; border-radius: 20px;
        font-family: inherit; font-size: 12px; font-weight: 700;
        border: none; cursor: pointer; transition: opacity .2s;
    }
    .prof-btn:hover { opacity: .85; }
    .prof-btn.orange { background: #FF5A36; color: #FFF; }
    .prof-btn.red    { background: #E53935; color: #FFF; }

    /* ── Tabs ─────────────────────────────────────────────── */
    .profile-tabs-nav {
        display: flex; gap: 0;
        border-bottom: 2px solid #EAE6DF;
        max-width: 1200px;
        margin: 32px auto 0;
        padding: 0 5%;
    }
    .tab-trigger {
        font-size: 14px; font-weight: 700; color: #777;
        padding: 14px 24px;
        border-bottom: 3px solid transparent;
        cursor: pointer; transition: all .2s;
        margin-bottom: -2px;
        background: none; border-top: none; border-left: none; border-right: none;
        font-family: inherit;
    }
    .tab-trigger:hover { color: #A03010; }
    .tab-trigger.active { color: #A03010; border-bottom-color: #A03010; }

    .tab-pane { display: none; max-width: 1200px; margin: 0 auto; padding: 28px 5% 60px; }
    .tab-pane.active { display: block; }

    /* ── Recipe Grid ──────────────────────────────────────── */
    .fav-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }
    .fav-card {
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .fav-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.08); }
    .fav-card-img {
        position: relative;
        height: 160px;
        overflow: hidden;
    }
    .fav-card-img img { width:100%; height:100%; object-fit:cover; transition: transform .3s; }
    .fav-card:hover .fav-card-img img { transform: scale(1.05); }

    .fav-heart {
        position: absolute; top: 10px; right: 10px;
        width: 30px; height: 30px;
        background: rgba(255,255,255,.92);
        border: 1px solid #EEE; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; color: #E53935; cursor: pointer;
        transition: transform .2s;
    }
    .fav-heart:hover { transform: scale(1.15); }

    .fav-cat-pill {
        position: absolute; bottom: 10px; left: 10px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 10px; font-weight: 800; color: #FFF;
    }

    .fav-body { padding: 14px; }
    .fav-title { font-size: 13px; font-weight: 800; color: #111; line-height: 1.3; margin: 0 0 6px; }
    .fav-meta { display: flex; gap: 8px; font-size: 10px; color: #888; font-weight: 600; margin-bottom: 12px; }

    .btn-cook {
        display: block; width: 100%;
        padding: 9px;
        border-radius: 10px;
        background: transparent;
        border: 1.5px solid #A03010;
        color: #A03010;
        font-family: inherit;
        font-size: 12px; font-weight: 700;
        text-align: center; text-decoration: none;
        transition: all .2s;
    }
    .btn-cook:hover { background: #A03010; color: #FFF; }

    /* Empty favorites */
    .empty-fav {
        text-align: center; padding: 60px 20px;
        grid-column: 1/-1;
    }
    .empty-fav i { font-size: 48px; color: #ddd; display: block; margin-bottom: 16px; }
    .empty-fav h3 { font-size: 18px; font-weight: 700; color: #888; margin-bottom: 8px; }
    .empty-fav p  { font-size: 13px; color: #aaa; margin-bottom: 20px; }

    /* ── Comments Tab ─────────────────────────────────────── */
    .comment-card {
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 14px;
    }
    .comment-head {
        display: flex; justify-content: space-between; align-items: flex-start;
        margin-bottom: 8px;
    }
    .comment-recipe-title { font-size: 13px; font-weight: 800; color: #111; }
    .comment-date { font-size: 11px; color: #aaa; }
    .comment-stars { color: #FFA500; font-size: 13px; margin-bottom: 6px; }
    .comment-text { font-size: 13px; color: #555; line-height: 1.6; font-style: italic; }
    .comment-status { font-size: 11px; font-weight: 700; margin-top: 8px; }
    .comment-status.approved { color: #2E7D32; }
    .comment-status.pending  { color: #FF9800; }

    /* ── Settings Form ────────────────────────────────────── */
    .settings-card {
        background: #FFF;
        border: 1px solid #EAE6DF;
        border-radius: 20px;
        padding: 32px;
    }
    .settings-card h3 {
        font-size: 18px; font-weight: 800; color: #111;
        margin: 0 0 24px; padding-bottom: 14px;
        border-bottom: 1px solid #F0EDE8;
    }
    .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
    .field-label { font-size: 11px; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 7px; }
    .field-input {
        width: 100%; padding: 12px 14px;
        border-radius: 10px; border: 1.5px solid #E0DDD8;
        font-family: inherit; font-size: 14px;
        outline: none; transition: border-color .2s;
        box-sizing: border-box;
    }
    .field-input:focus { border-color: #A03010; }

    @media (max-width: 900px) {
        .fav-grid { grid-template-columns: 1fr 1fr; }
        .field-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .profile-hero-inner { flex-direction: column; text-align: center; }
        .profile-stats { justify-content: center; }
        .fav-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

@if(Auth::user()->role === 'chef' || Auth::user()->role === 'admin')
    <!-- Chef & Admin Settings Layout -->
    <div style="margin-bottom:26px">
        <h1 style="font-size:28px;font-weight:700;color:#111">Pengaturan Akun</h1>
        <p style="color:var(--text-m);margin-top:4px">Perbarui informasi profil dan kata sandi akun Anda.</p>
    </div>

    <div class="white-card">
        @if(session('success'))
        <div style="background:#E8F5E9; border:1px solid #A5D6A7; border-radius:10px; padding:12px 18px; margin-bottom:20px; color:#2E7D32; font-weight:600; font-size:13px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div style="background:#FFEBEE; border:1px solid #FFCDD2; border-radius:10px; padding:12px 18px; margin-bottom:20px; color:#C62828; font-size:13px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="field-grid">
                <div>
                    <label class="field-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="field-input" required>
                </div>
                <div>
                    <label class="field-label">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="field-input" required>
                </div>
            </div>

            <h3 style="margin-top:20px; font-size:16px; font-weight:800; color:#111; margin-bottom:14px; padding-bottom:8px; border-bottom:1px solid #F0EDE8;"><i class="fas fa-lock" style="color:#FF9800; margin-right:8px;"></i> Ubah Kata Sandi <span style="font-size:12px; font-weight:500; color:#aaa;">(Opsional)</span></h3>

            <div class="field-grid" style="margin-bottom:28px;">
                <div>
                    <label class="field-label">Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" class="field-input">
                </div>
                <div>
                    <label class="field-label">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="field-input">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@else

{{-- ── Profile Hero ── --}}
<div class="profile-hero">
    <div class="profile-hero-inner">
        <div class="avatar-wrap">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
            <div class="avatar-edit" onclick="switchTab('settings')"><i class="fas fa-pencil-alt"></i></div>
        </div>

        <div style="flex:1;">
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:2px;">
                <h1 class="profile-name">{{ $user->name }}</h1>
                @if($user->hasActiveVip())
                <span class="badge-vip"><i class="fas fa-crown"></i> VIP</span>
                @endif
            </div>

            <p class="profile-bio">
                {{ $user->bio ?? 'Belum ada bio. Klik Edit Profile untuk mengisi.' }}
            </p>

            <div class="profile-stats">
                <span><strong>{{ $savedRecipes->count() }}</strong> Favorit</span>
                <span>•</span>
                <span><strong>{{ $myComments->count() }}</strong> Ulasan</span>
            </div>

            <div style="display:flex; gap:10px; margin-top:16px; flex-wrap:wrap;">
                <button class="prof-btn orange" onclick="switchTab('settings')">
                    <i class="far fa-edit"></i> Edit Profil
                </button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="prof-btn red">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── Tabs Navigation ── --}}
<div class="profile-tabs-nav">
    <button class="tab-trigger active" id="tab-fav-btn" onclick="switchTab('fav')">
        <i class="fas fa-heart" style="color:#E53935; margin-right:6px;"></i>
        Resep Favorit
        <span style="background:#A03010; color:#FFF; border-radius:20px; padding:1px 8px; font-size:10px; margin-left:6px;">
            {{ $savedRecipes->count() }}
        </span>
    </button>
    <button class="tab-trigger" id="tab-comments-btn" onclick="switchTab('comments')">
        <i class="fas fa-star" style="color:#FFA500; margin-right:6px;"></i>
        Ulasan Saya
        <span style="background:#EAE6DF; color:#555; border-radius:20px; padding:1px 8px; font-size:10px; margin-left:6px;">
            {{ $myComments->count() }}
        </span>
    </button>
    <button class="tab-trigger" id="tab-settings-btn" onclick="switchTab('settings')">
        <i class="fas fa-cog" style="margin-right:6px;"></i>
        Pengaturan Akun
    </button>
</div>

{{-- ── Tab: Favorit ── --}}
<div class="tab-pane active" id="tab-fav">

    @if(session('success'))
    <div style="background:#E8F5E9; border:1px solid #A5D6A7; border-radius:10px; padding:12px 18px; margin-bottom:20px; color:#2E7D32; font-weight:600; font-size:13px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="fav-grid">
        @forelse($savedRecipes as $recipe)
        <div class="fav-card">
            <div class="fav-card-img">
                <img
                    src="{{ $recipe->image ? asset('storage/'.$recipe->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80' }}"
                    alt="{{ $recipe->title }}"
                    onerror="this.src='https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=400&q=80'"
                >
                {{-- Remove from favorites --}}
                <form method="POST" action="{{ route('recipes.save', $recipe) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="fav-heart" title="Hapus dari favorit">
                        <i class="fas fa-heart"></i>
                    </button>
                </form>
                @if($recipe->category)
                <span class="fav-cat-pill" style="background:#A03010;">{{ $recipe->category->name }}</span>
                @endif
            </div>
            <div class="fav-body">
                <h4 class="fav-title">{{ $recipe->title }}</h4>
                <div class="fav-meta">
                    <span><i class="far fa-clock"></i> {{ $recipe->total_time }} mnt</span>
                    <span>•</span>
                    <span><i class="fas fa-signal"></i> {{ $recipe->difficulty_label }}</span>
                    @if($recipe->is_vip_content)
                    <span><i class="fas fa-crown" style="color:#FFD700;"></i></span>
                    @endif
                </div>
                <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn-cook">
                    Masak Sekarang
                </a>
            </div>
        </div>
        @empty
        <div class="empty-fav">
            <i class="far fa-heart"></i>
            <h3>Belum ada resep favorit</h3>
            <p>Klik ikon ❤️ di halaman resep untuk menyimpan resep favorit kamu.</p>
            <a href="{{ route('recipes.index') }}"
               style="display:inline-flex; align-items:center; gap:8px; padding:11px 24px; background:#A03010; color:#FFF; border-radius:20px; font-weight:700; font-size:13px; text-decoration:none;">
                <i class="fas fa-search"></i> Temukan Resep
            </a>
        </div>
        @endforelse
    </div>
</div>

{{-- ── Tab: Ulasan ── --}}
<div class="tab-pane" id="tab-comments">
    @forelse($myComments as $cmt)
    <div class="comment-card">
        <div class="comment-head">
            <div>
                <div class="comment-recipe-title">
                    <i class="fas fa-utensils" style="color:#A03010; margin-right:5px;"></i>
                    {{ $cmt->recipe->title ?? 'Resep dihapus' }}
                </div>
                <div class="comment-stars">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= $cmt->rating ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                    <span style="font-size:12px; color:#888; font-weight:600; margin-left:4px;">{{ $cmt->rating }}/5</span>
                </div>
            </div>
            <span class="comment-date">{{ $cmt->created_at->diffForHumans() }}</span>
        </div>
        @if($cmt->comment)
        <p class="comment-text">"{{ $cmt->comment }}"</p>
        @endif
        <div class="comment-status {{ $cmt->is_approved ? 'approved' : 'pending' }}">
            <i class="fas {{ $cmt->is_approved ? 'fa-check-circle' : 'fa-clock' }}"></i>
            {{ $cmt->is_approved ? 'Disetujui' : 'Menunggu moderasi' }}
        </div>
    </div>
    @empty
    <div style="text-align:center; padding:50px; color:#aaa;">
        <i class="fas fa-star" style="font-size:44px; opacity:.3; display:block; margin-bottom:14px;"></i>
        <h3 style="font-size:17px; font-weight:700; color:#888; margin-bottom:8px;">Belum ada ulasan</h3>
        <p style="font-size:13px; margin-bottom:18px;">Kunjungi resep dan berikan rating & komentar kamu!</p>
        <a href="{{ route('recipes.index') }}"
           style="display:inline-flex; align-items:center; gap:8px; padding:11px 24px; background:#A03010; color:#FFF; border-radius:20px; font-weight:700; font-size:13px; text-decoration:none;">
            <i class="fas fa-utensils"></i> Jelajah Resep
        </a>
    </div>
    @endforelse
</div>

{{-- ── Tab: Settings ── --}}
<div class="tab-pane" id="tab-settings">
    <div class="settings-card">
        <h3><i class="fas fa-user-edit" style="color:#A03010; margin-right:8px;"></i> Perbarui Informasi Profil</h3>

        @if($errors->any())
        <div style="background:#FFEBEE; border:1px solid #FFCDD2; border-radius:10px; padding:12px 18px; margin-bottom:20px; color:#C62828; font-size:13px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="field-grid">
                <div>
                    <label class="field-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="field-input" required>
                </div>
                <div>
                    <label class="field-label">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="field-input" required>
                </div>
            </div>

            <h3 style="margin-top:0;"><i class="fas fa-lock" style="color:#FF9800; margin-right:8px;"></i> Ubah Kata Sandi <span style="font-size:12px; font-weight:500; color:#aaa;">(Opsional)</span></h3>

            <div class="field-grid" style="margin-bottom:28px;">
                <div>
                    <label class="field-label">Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" class="field-input">
                </div>
                <div>
                    <label class="field-label">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="field-input">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit"
                    style="background:#A03010; color:#FFF; font-size:14px; padding:12px 28px; border-radius:12px; font-weight:700; border:none; cursor:pointer; font-family:inherit; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endif

@endsection

@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-trigger').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('tab-' + tab + '-btn').classList.add('active');
}

// Auto-open settings tab if there are validation errors
@if($errors->any())
switchTab('settings');
@endif

// Auto-open settings tab if redirected with hash
if (window.location.hash === '#settings') switchTab('settings');
</script>
@endpush
