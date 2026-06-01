@extends('layouts.app')
@section('title', 'Profil Saya')

@push('styles')
<style>
    .profile-hero {
        background: #FFF;
        border-bottom: 1px solid #EAE6DF;
        padding: 50px 5%;
    }
    .profile-header-layout {
        display: flex;
        gap: 36px;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }
    .avatar-picker-container {
        position: relative;
        width: 150px;
        height: 150px;
    }
    .profile-avatar-big {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary);
        box-shadow: 0 10px 24px rgba(255,90,54,0.15);
    }
    .pencil-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #A03010;
        color: #FFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: 2px solid #FFF;
        cursor: pointer;
    }
    .btn-edit-profile {
        padding: 6px 16px;
        border-radius: 20px;
        background: #FF5A36;
        color: #FFF;
        font-weight: 700;
        font-size: 12px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity 0.2s;
    }
    .btn-edit-profile:hover {
        opacity: 0.9;
    }
    .stats-row {
        display: flex;
        gap: 24px;
        margin-top: 16px;
        font-size: 14px;
        font-weight: 500;
        color: #777;
    }
    .stats-row strong {
        color: #111;
        font-weight: 800;
    }

    /* Tabs */
    .profile-tabs-nav {
        display: flex;
        gap: 40px;
        border-bottom: 1px solid #EAE6DF;
        max-width: 1200px;
        margin: 40px auto 28px;
        padding: 0 20px;
    }
    .tab-trigger {
        font-size: 15px;
        font-weight: 700;
        color: #777;
        padding-bottom: 14px;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tab-trigger.active {
        color: #A03010;
        border-bottom-color: #A03010;
    }

    .tab-content {
        display: none;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 60px;
    }
    .tab-content.active {
        display: block;
    }

    /* Recipe cards matching profile figma */
    .recipe-profile-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .btn-cook-now {
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        background: transparent;
        border: 1.5px solid #FF5A36;
        color: #FF5A36;
        font-weight: 700;
        font-size: 12px;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .btn-cook-now:hover {
        background: #FF5A36;
        color: #FFF;
    }

    @media (max-width: 768px) {
        .profile-header-layout { flex-direction: column; text-align: center; }
        .recipe-profile-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')

<!-- User Header Hero -->
<div class="profile-hero">
    <div class="profile-header-layout">
        <div class="avatar-picker-container">
            <img src="{{ $user->avatar_url }}" class="profile-avatar-big" alt="">
            <div class="pencil-badge"><i class="fas fa-pencil-alt"></i></div>
        </div>

        <div style="flex:1;">
            <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                <h1 style="font-size:32px; font-weight:800; color:#111; font-family:'Outfit',sans-serif;">{{ $user->name }}</h1>
                <button class="btn-edit-profile" onclick="switchTab('settings')"><i class="far fa-edit"></i> EDIT PROFILE</button>
            </div>
            
            <p style="font-size:14px; color:#555; max-width:640px; margin-top:10px; line-height:1.6;">
                Cooking my way through Jakarta, one spice at a time. Lover of authentic Sambal and modern fusion experiments. Making home cooking fun for everyone! 🌶️🍳
            </p>

            <div class="stats-row">
                <span><strong>24</strong> Recipes</span>
                <span>•</span>
                <span><strong>1.2k</strong> Followers</span>
                <span>•</span>
                <span><strong>86</strong> Following</span>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="profile-tabs-nav">
    <div class="tab-trigger active" id="recipes-trigger" onclick="switchTab('recipes')">My Favorite Recipes</div>
    <div class="tab-trigger" id="comments-trigger" onclick="switchTab('comments')">My Comments</div>
    <div class="tab-trigger" id="settings-trigger" onclick="switchTab('settings')">Account Settings</div>
</div>

<!-- Tab 1: Favorite Recipes -->
<div class="tab-content active" id="recipes-tab">
    <div class="recipe-profile-grid">
        <!-- Card 1 -->
        <div class="recipe-card-modern" style="position:relative;">
            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80" style="height:180px;" alt="">
            <span class="recipe-tag-pill" style="background:#2E7D32;">Healthy</span>
            <button class="heart-float"><i class="fas fa-heart"></i></button>
            <div style="padding:16px;">
                <h4 style="font-size:13px; font-weight:800; color:#111;">Summer Avocado Quinoa Bowl</h4>
                <div style="display:flex; gap:10px; font-size:10px; color:#777; margin-top:6px; font-weight:600;">
                    <span><i class="far fa-clock"></i> 15 min</span>
                    <span>•</span>
                    <span>Easy</span>
                </div>
                <button class="btn-cook-now">COOK NOW</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="recipe-card-modern" style="position:relative;">
            <img src="https://images.unsplash.com/photo-1574484284002-952d92456975?w=400&q=80" style="height:180px;" alt="">
            <span class="recipe-tag-pill" style="background:#A03010;">Authentic</span>
            <button class="heart-float"><i class="fas fa-heart"></i></button>
            <div style="padding:16px;">
                <h4 style="font-size:13px; font-weight:800; color:#111;">Slow-Cooked Beef Rendang</h4>
                <div style="display:flex; gap:10px; font-size:10px; color:#777; margin-top:6px; font-weight:600;">
                    <span><i class="far fa-clock"></i> 120 min</span>
                    <span>•</span>
                    <span>Expert</span>
                </div>
                <button class="btn-cook-now">COOK NOW</button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="recipe-card-modern" style="position:relative;">
            <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400&q=80" style="height:180px;" alt="">
            <span class="recipe-tag-pill" style="background:#1565C0;">Fusion</span>
            <button class="heart-float"><i class="fas fa-heart"></i></button>
            <div style="padding:16px;">
                <h4 style="font-size:13px; font-weight:800; color:#111;">Thin Crust Margherita</h4>
                <div style="display:flex; gap:10px; font-size:10px; color:#777; margin-top:6px; font-weight:600;">
                    <span><i class="far fa-clock"></i> 30 min</span>
                    <span>•</span>
                    <span>Medium</span>
                </div>
                <button class="btn-cook-now">COOK NOW</button>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="recipe-card-modern" style="position:relative;">
            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&q=80" style="height:180px;" alt="">
            <span class="recipe-tag-pill" style="background:#FF9800;">Quick Bite</span>
            <button class="heart-float"><i class="fas fa-heart"></i></button>
            <div style="padding:16px;">
                <h4 style="font-size:13px; font-weight:800; color:#111;">Basil Pesto Penne</h4>
                <div style="display:flex; gap:10px; font-size:10px; color:#777; margin-top:6px; font-weight:600;">
                    <span><i class="far fa-clock"></i> 20 min</span>
                    <span>•</span>
                    <span>Easy</span>
                </div>
                <button class="btn-cook-now">COOK NOW</button>
            </div>
        </div>
    </div>
</div>

<!-- Tab 2: Comments -->
<div class="tab-content" id="comments-tab">
    <div style="background:#FFF; border-radius:16px; border:1px solid #EAE6DF; padding:24px;">
        <h4 style="font-size:16px; font-weight:800; color:#111; margin-bottom:16px;">My Comment History</h4>
        <div style="display:flex; flex-direction:column; gap:16px;">
            <div style="padding-bottom:16px; border-bottom:1px solid #F0F0F0;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong style="font-size:13px; color:#111;">Commented on Rendang Padang</strong>
                    <span style="font-size:11px; color:#999;">Yesterday</span>
                </div>
                <p style="font-size:13px; color:#555; margin-top:6px;">"The tips on slow searing the beef were incredibly helpful! Melt-in-the-mouth texture!"</p>
            </div>
            <div style="padding-bottom:16px; border-bottom:1px solid #F0F0F0;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong style="font-size:13px; color:#111;">Commented on Lava Cake Cokelat</strong>
                    <span style="font-size:11px; color:#999;">3 days ago</span>
                </div>
                <p style="font-size:13px; color:#555; margin-top:6px;">"Perfect timing is exactly 9 minutes, thank you Chef!"</p>
            </div>
        </div>
    </div>
</div>

<!-- Tab 3: Account Settings Form -->
<div class="tab-content" id="settings-tab">
    <div style="background:#FFF; border-radius:20px; padding:36px; border:1px solid #EAE6DF; box-shadow:0 6px 20px rgba(0,0,0,0.01);">
        <h3 style="font-size:20px; font-weight:800; color:#111; margin-bottom:24px; border-bottom:1px solid #F8F9FA; padding-bottom:14px;">
            <i class="fas fa-user-edit" style="color:var(--primary); margin-right:8px;"></i> Perbarui Informasi Profil
        </h3>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
                <div class="form-group">
                    <label class="form-label" style="font-size:11px; font-weight:700; color:#333; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px; display:block;">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" style="padding:12px 16px; border-radius:10px; border:1px solid #DDD; width:100%; font-size:14px; outline:none;" required>
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size:11px; font-weight:700; color:#333; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px; display:block;">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" style="padding:12px 16px; border-radius:10px; border:1px solid #DDD; width:100%; font-size:14px; outline:none;" required>
                </div>
            </div>

            <h3 style="font-size:20px; font-weight:800; color:#111; margin:36px 0 24px 0; border-bottom:1px solid #F8F9FA; padding-bottom:14px;">
                <i class="fas fa-lock" style="color:#FF9800; margin-right:8px;"></i> Ubah Kata Sandi <span style="font-size:13px; font-weight:500; color:#aaa;">(Opsional)</span>
            </h3>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px;">
                <div class="form-group">
                    <label class="form-label" style="font-size:11px; font-weight:700; color:#333; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px; display:block;">Kata Sandi Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" style="padding:12px 16px; border-radius:10px; border:1px solid #DDD; width:100%; font-size:14px; outline:none;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size:11px; font-weight:700; color:#333; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px; display:block;">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" style="padding:12px 16px; border-radius:10px; border:1px solid #DDD; width:100%; font-size:14px; outline:none;">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" class="btn" style="background:#A03010; color:#FFF; font-size:14px; padding:12px 28px; border-radius:10px; font-weight:700; border:none; cursor:pointer;">
                    <i class="fas fa-save" style="margin-right:8px;"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(tabId) {
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.tab-trigger').forEach(t => t.classList.remove('active'));

    // Show selected
    document.getElementById(tabId + '-tab').classList.add('active');
    document.getElementById(tabId + '-trigger').classList.add('active');
}
</script>
@endpush
