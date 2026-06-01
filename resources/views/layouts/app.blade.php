<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RasaRekomendasi') — Platform Resep Gen Z Indonesia</title>
    <meta name="description" content="@yield('description', 'Temukan ribuan resep masakan Indonesia dengan rekomendasi personal dan konsultasi chef profesional.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary:      #FF5A36;
            --primary-h:    #E04D2C;
            --primary-l:    #FF7A5A;
            --primary-bg:   #FFF0EC;
            --bg:           #FDFCF8;
            --bg-dash:      #F4F6F8;
            --white:        #FFFFFF;
            --text:         #333333;
            --text-m:       #777777;
            --text-l:       #AAAAAA;
            --border:       #EEEEEE;
            --input-bg:     #F4F2EB;
            --radius:       16px;
            --radius-sm:    10px;
            --shadow-sm:    0 4px 12px rgba(0,0,0,0.05);
            --shadow-md:    0 10px 30px rgba(0,0,0,0.08);
            --shadow-lg:    0 20px 50px rgba(0,0,0,0.12);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
        a { text-decoration: none; color: var(--primary); transition: color .2s; }
        a:hover { color: var(--primary-h); }
        img { max-width: 100%; }

        /* ── Navbar ── */
        .top-navbar {
            background: var(--white);
            padding: 0 50px;
            height: 68px;
            display: flex; align-items: center;
            position: sticky; top: 0; z-index: 100;
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .nav-brand {
            font-size: 20px; font-weight: 800;
            color: var(--primary); flex: 1;
        }
        .nav-center {
            flex: 2; display: flex;
            justify-content: center; gap: 36px;
        }
        .nav-center a {
            color: var(--text-m); font-weight: 600;
            font-size: 14px; transition: color .2s;
            display: flex; align-items: center; gap: 6px;
        }
        .nav-center a.active, .nav-center a:hover { color: var(--primary); }
        .nav-right {
            flex: 1; display: flex;
            align-items: center; justify-content: flex-end;
            gap: 16px;
        }
        .nav-search {
            position: relative; width: 220px;
        }
        .nav-search i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999; font-size: 13px; }
        .nav-search input {
            width: 100%; padding: 9px 16px 9px 38px;
            background: var(--bg-dash); border: none;
            border-radius: 20px; font-family: inherit;
            font-size: 13px; color: var(--text); outline: none;
            transition: background .2s;
        }
        .nav-search input:focus { background: #ece9e0; }
        .nav-icon { color: var(--text-m); font-size: 18px; cursor: pointer; transition: color .2s; }
        .nav-icon:hover { color: var(--primary); }
        .nav-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            object-fit: cover; cursor: pointer;
            border: 2px solid var(--primary-bg);
        }
        .nav-avatar-wrap { position: relative; }
        .avatar-dropdown {
            display: none; position: absolute; right: 0; top: calc(100% + 8px);
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--radius); min-width: 200px;
            box-shadow: var(--shadow-md); overflow: hidden; z-index: 200;
        }
        .avatar-dropdown.show { display: block; }
        .avatar-dropdown-header { padding: 14px 16px; border-bottom: 1px solid var(--border); }
        .avatar-dropdown-header strong { display: block; font-size: 14px; }
        .avatar-dropdown-header span { font-size: 12px; color: var(--text-m); }
        .avatar-dropdown a, .avatar-dropdown button {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 11px 16px;
            color: var(--text); font-size: 14px; font-family: inherit;
            background: none; border: none; cursor: pointer; text-align: left;
            transition: background .15s;
        }
        .avatar-dropdown a:hover, .avatar-dropdown button:hover { background: var(--bg-dash); color: var(--primary); }
        .avatar-dropdown .divider { height: 1px; background: var(--border); }
        .nav-vip-badge {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #000; font-size: 10px; font-weight: 800;
            padding: 3px 8px; border-radius: 20px;
            letter-spacing: .05em;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 24px; background: var(--primary); color: var(--white);
            border-radius: var(--radius-sm); border: none; font-family: inherit;
            font-size: 14px; font-weight: 600; cursor: pointer;
            transition: all .25s; text-decoration: none;
        }
        .btn:hover { background: var(--primary-h); color: var(--white); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,90,54,.3); }
        .btn-outline {
            background: transparent; color: var(--primary);
            border: 2px solid var(--primary);
        }
        .btn-outline:hover { background: var(--primary); color: var(--white); }
        .btn-sm { padding: 8px 16px; font-size: 13px; }
        .btn-lg { padding: 15px 36px; font-size: 16px; border-radius: 30px; }
        .btn-ghost { background: var(--bg-dash); color: var(--text); }
        .btn-ghost:hover { background: #e5e5e5; color: var(--text); }
        .btn-nav-login {
            display: inline-flex;
            align-items: center;
            padding: 8px 24px;
            border-radius: 20px;
            border: 1.5px solid #FF5A36;
            color: #FF5A36;
            background: transparent;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-nav-login:hover {
            background: #FFF0EC;
        }
        .btn-nav-register {
            display: inline-flex;
            align-items: center;
            padding: 9px 24px;
            border-radius: 20px;
            background: #FF5A36;
            color: #FFF;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(255, 90, 54, 0.15);
        }
        .btn-nav-register:hover {
            background: #E04D2C;
        }

        /* ── Cards ── */
        .card {
            background: var(--white); border-radius: var(--radius);
            box-shadow: var(--shadow-sm); border: 1px solid #f2f2f2;
            transition: transform .3s, box-shadow .3s;
        }
        .card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }

        /* ── Alerts ── */
        .alert { padding: 12px 18px; border-radius: var(--radius-sm); margin-bottom: 16px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .alert-danger { background: #FFF0F0; border: 1px solid #ffd0d0; color: #c0392b; }
        .alert-success { background: #F0FFF4; border: 1px solid #b2dfdb; color: #1b5e20; }
        .alert-info { background: #EFF8FF; border: 1px solid #bee3f8; color: #1a5276; }

        /* ── Forms ── */
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 7px; color: var(--text); }
        .form-control {
            width: 100%; padding: 13px 18px;
            background: var(--input-bg); border: 2px solid transparent;
            border-radius: var(--radius-sm); font-family: inherit;
            font-size: 14px; color: var(--text); outline: none;
            transition: border-color .2s, background .2s;
        }
        .form-control:focus { border-color: var(--primary); background: var(--white); }
        .form-control::placeholder { color: var(--text-l); }
        .form-error { font-size: 12px; color: #e74c3c; margin-top: 5px; }
        select.form-control { cursor: pointer; }

        /* ── Container ── */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 5%; }
        .page-padding { padding: 40px 5%; }

        /* ── Recipe Cards ── */
        .recipe-card {
            background: var(--white); border-radius: 20px;
            overflow: hidden; box-shadow: var(--shadow-sm);
            transition: .3s; border: 1px solid #f2f2f2;
            display: flex; flex-direction: column;
        }
        .recipe-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-md); }
        .recipe-card-img {
            height: 220px; background-size: cover; background-position: center;
            position: relative;
        }
        .recipe-card-content { padding: 22px; flex: 1; }
        .recipe-card-meta { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; font-size: 12px; font-weight: 700; }
        .meta-tag { background: var(--bg-dash); padding: 5px 12px; border-radius: 8px; color: #555; }
        .meta-tag.hot { background: #FFF0EC; color: var(--primary); }
        .meta-tag.green { background: #E8F5E9; color: #2E7D32; }
        .meta-tag.blue { background: #E3F2FD; color: #1565C0; }
        .recipe-card h3 { font-size: 19px; font-weight: 700; margin-bottom: 12px; color: var(--text); line-height: 1.3; }
        .recipe-author { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-m); }
        .recipe-author img { width: 30px; height: 30px; border-radius: 50%; object-fit: cover; }
        .vip-lock {
            position: absolute; top: 12px; right: 12px;
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #000; font-size: 10px; font-weight: 800;
            padding: 4px 10px; border-radius: 20px;
            letter-spacing: .04em;
        }
        .save-btn {
            position: absolute; top: 12px; left: 12px;
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--white); display: flex; align-items: center; justify-content: center;
            box-shadow: var(--shadow-sm); color: #ccc;
            cursor: pointer; border: none; font-size: 16px;
            transition: color .2s;
        }
        .save-btn.saved, .save-btn:hover { color: var(--primary); }

        /* ── Grids ── */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
        .grid-auto { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }

        /* ── Footer ── */
        footer {
            background: var(--bg); border-top: 1px solid var(--border);
            padding: 40px 5%; text-align: center;
            color: var(--text-m); font-size: 14px;
        }
        .footer-brand { color: var(--primary); font-weight: 800; font-size: 18px; margin-bottom: 10px; }
        .footer-links { display: flex; justify-content: center; gap: 24px; margin: 14px 0; flex-wrap: wrap; }
        .footer-links a { color: var(--text-m); font-size: 13px; }
        .footer-links a:hover { color: var(--primary); }

        /* ── Section Header ── */
        .section-header {
            display: flex; justify-content: space-between;
            align-items: flex-end; margin-bottom: 28px;
        }
        .section-header h2 { font-size: 28px; font-weight: 800; line-height: 1.2; }
        .section-header h2 span { color: var(--text-m); font-size: 14px; font-weight: 500; display: block; margin-top: 4px; }
        .section-header a { font-weight: 700; color: var(--primary); font-size: 14px; }

        /* ── Badge ── */
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; }
        .badge-primary { background: var(--primary-bg); color: var(--primary); }
        .badge-green { background: #E8F5E9; color: #2E7D32; }
        .badge-gold { background: linear-gradient(135deg, #FFF9C4, #FFD54F); color: #7c5b00; }

        @media (max-width: 768px) {
            .top-navbar { padding: 0 20px; }
            .nav-center { display: none; }
            .nav-search { width: 160px; }
            .grid-3, .grid-4 { grid-template-columns: 1fr 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .grid-3, .grid-4, .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="top-navbar">
    <a href="{{ route('welcome') }}" class="nav-brand">RasaRekomendasi</a>

    <div class="nav-center">
        <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">Beranda</a>
        @auth
            <a href="{{ route('recipes.index') }}" class="{{ request()->routeIs('recipes.*') ? 'active' : '' }}">Daftar Resep</a>
            <a href="{{ route('recommendations.index') }}" class="{{ request()->routeIs('recommendations.*') ? 'active' : '' }}">Rekomendasi</a>
            <a href="{{ route('vip.index') }}" class="{{ request()->routeIs('vip.*') ? 'active' : '' }}">Paket VIP</a>
        @else
            <a href="{{ route('recipes.index') }}">Daftar Resep</a>
            <a href="{{ route('recommendations.index') }}">Rekomendasi</a>
            <a href="{{ route('vip.index') }}">Paket VIP</a>
        @endauth
    </div>

    <div class="nav-right">
        <div class="nav-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari resep..." id="globalSearch">
        </div>

        @guest
            <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
            <a href="{{ route('register') }}" class="btn-nav-register">Daftar</a>
        @else
            <i class="far fa-bell nav-icon"></i>
            <i class="far fa-heart nav-icon"></i>
            <div class="nav-avatar-wrap">
                <img src="{{ Auth::user()->avatar_url }}"
                     alt="{{ Auth::user()->name }}"
                     class="nav-avatar"
                     onclick="toggleAvatarMenu()"
                     id="navAvatar">
                <div class="avatar-dropdown" id="avatarMenu">
                    <div class="avatar-dropdown-header">
                        <strong>{{ Auth::user()->name }}</strong>
                        <span>
                            @if(Auth::user()->isAdmin()) Admin
                            @elseif(Auth::user()->isChef()) Chef
                            @elseif(Auth::user()->hasActiveVip()) <span class="nav-vip-badge">VIP</span>
                            @else User
                            @endif
                        </span>
                    </div>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Admin Panel</a>
                    @elseif(Auth::user()->isChef())
                        <a href="{{ route('chef.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Chef Panel</a>
                    @else
                        <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}"><i class="fas fa-user-circle"></i> Profil Saya</a>
                    @if(!Auth::user()->hasActiveVip() && Auth::user()->isUser())
                        <a href="{{ route('vip.index') }}"><i class="fas fa-crown" style="color:#FFD700"></i> Upgrade VIP</a>
                    @endif
                    <div class="divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>

{{-- Flash Messages --}}
<div style="max-width:1280px;margin:0 auto;padding:0 5%">
    @if(session('success'))
        <div class="alert alert-success" style="margin-top:12px"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin-top:12px"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
</div>

@yield('content')

<footer>
    <div class="footer-brand">RasaRekomendasi</div>
    <div class="footer-links">
        <a href="#">About Us</a>
        <a href="#">Terms of Service</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Contact</a>
    </div>
    <p>&copy; 2026 RasaRekomendasi. Built for Gen Z Home Chefs.</p>
</footer>

<script>
function toggleAvatarMenu() {
    document.getElementById('avatarMenu').classList.toggle('show');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.nav-avatar-wrap')) {
        document.getElementById('avatarMenu')?.classList.remove('show');
    }
});

// Global search redirect on Enter
document.getElementById('globalSearch')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && this.value.trim()) {
        window.location.href = '{{ route("recipes.index") }}?q=' + encodeURIComponent(this.value.trim());
    }
});
</script>
@stack('scripts')
</body>
</html>
