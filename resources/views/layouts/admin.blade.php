<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title') | RasaRekomendasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{--primary:#FF5A36;--primary-h:#E04D2C;--primary-bg:#FFF0EC;--bg:#F8F9FA;--white:#FFFFFF;--text:#333;--text-m:#777;--border:#EEE;--radius:16px;--radius-sm:10px;--shadow:0 4px 15px rgba(0,0,0,.04);}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Outfit',sans-serif;background:var(--bg);color:var(--text);}
        a{text-decoration:none;color:inherit;transition:color .2s;}
        .admin-sidebar{position:fixed;top:0;left:0;width:250px;height:100vh;background:var(--white);border-right:1px solid var(--border);display:flex;flex-direction:column;justify-content:space-between;z-index:100;}
        .admin-brand{padding:28px 28px 20px;}
        .admin-brand h2{font-size:20px;font-weight:800;color:var(--primary);}
        .admin-brand p{font-size:11px;color:var(--text-m);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-top:2px;}
        .admin-menu{list-style:none;}
        .admin-menu li a{display:flex;align-items:center;gap:14px;padding:13px 20px 13px 28px;font-size:14px;font-weight:500;color:#555;border-radius:0 30px 30px 0;margin-right:20px;transition:all .2s;}
        .admin-menu li a i{width:20px;text-align:center;}
        .admin-menu li a:hover,.admin-menu li a.active{background:var(--primary-bg);color:var(--primary);}
        .admin-menu li a.active{font-weight:600;box-shadow:inset -3px 0 0 var(--primary);}
        .sidebar-user{padding:16px 24px;border-top:1px solid var(--border);display:flex;align-items:center;gap:12px;}
        .sidebar-user img{width:36px;height:36px;border-radius:50%;object-fit:cover;}
        .sidebar-user h4{font-size:13px;font-weight:700;margin:0;}
        .sidebar-user p{font-size:11px;color:var(--text-m);margin:0;}
        .admin-main{margin-left:250px;min-height:100vh;padding:32px 48px;flex:1;min-width:0;}
        .admin-topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;}
        .admin-search{position:relative;}
        .admin-search i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#aaa;font-size:13px;}
        .admin-search input{padding:10px 16px 10px 38px;width:280px;background:var(--white);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:inherit;font-size:13px;outline:none;}
        .topbar-right{display:flex;align-items:center;gap:16px;color:var(--text-m);font-size:18px;}
        .topbar-right img{width:34px;height:34px;border-radius:50%;}
        .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:var(--radius-sm);font-family:inherit;font-size:14px;font-weight:600;cursor:pointer;border:none;transition:all .2s;}
        .btn-primary{background:var(--primary);color:#fff;}
        .btn-primary:hover{background:var(--primary-h);}
        .btn-white{background:var(--white);color:var(--text);border:1px solid var(--border);}
        .btn-white:hover{border-color:var(--primary);color:var(--primary);}
        .btn-sm{padding:7px 14px;font-size:12px;}
        .btn-danger{background:#FFEBEE;color:#C62828;border:none;}
        .btn-success{background:#E8F5E9;color:#2E7D32;border:none;}
        .stat-card{background:#FFF9EF;border-radius:20px;padding:24px;position:relative;}
        .stat-card.orange{background:var(--primary);color:#fff;}
        .stat-icon{width:48px;height:48px;background:#fff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary);margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.06);}
        .stat-card.orange .stat-icon{background:rgba(255,255,255,.2);color:#fff;box-shadow:none;}
        .stat-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#777;margin-bottom:4px;}
        .stat-card.orange .stat-label{color:rgba(255,255,255,.85);}
        .stat-value{font-size:34px;font-weight:800;color:#111;line-height:1;}
        .stat-card.orange .stat-value{color:#fff;}
        .stat-trend{position:absolute;top:20px;right:20px;background:#E8F5E9;color:#2E7D32;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;}
        .stat-card.orange .stat-trend{background:rgba(255,255,255,.2);color:#fff;}
        .white-card{background:var(--white);border-radius:20px;padding:26px;box-shadow:var(--shadow);}
        .card-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;}
        .card-hdr h3{font-size:19px;font-weight:700;color:#111;}
        .card-hdr p{font-size:13px;color:var(--text-m);margin-top:3px;}
        table{width:100%;border-collapse:collapse;}
        th{text-align:left;padding:11px 10px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#aaa;border-bottom:1px solid var(--border);}
        td{padding:13px 10px;border-bottom:1px solid #f8f8f8;vertical-align:middle;font-size:14px;}
        tr:last-child td{border-bottom:none;}
        .td-img{display:flex;align-items:center;gap:12px;}
        .td-img img{width:42px;height:42px;border-radius:10px;object-fit:cover;}
        .td-img h4{font-size:14px;font-weight:600;color:#111;margin-bottom:2px;}
        .td-img p{font-size:12px;color:var(--text-m);}
        .td-chef{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500;}
        .td-chef img{width:24px;height:24px;border-radius:50%;}
        .badge{padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;}
        .badge-pending{background:#F3E5F5;color:#7B1FA2;}
        .badge-flagged{background:#FFEBEE;color:#C62828;}
        .badge-active{background:#E8F5E9;color:#2E7D32;}
        .badge-pub{background:#E3F2FD;color:#1565C0;}
        .td-acts{display:flex;gap:6px;}
        .tact{width:28px;height:28px;border-radius:50%;border:none;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;transition:opacity .2s;}
        .tact:hover{opacity:.8;}
        .tact-ok{background:var(--primary);color:#fff;}
        .tact-no{background:var(--white);color:#C62828;border:1px solid var(--border);}
        .tact-edit{background:#E3F2FD;color:#1565C0;}
        .tact-del{background:#FFEBEE;color:#C62828;}
        .progress-bar{height:6px;background:#eee;border-radius:3px;overflow:hidden;}
        .progress-fill{height:100%;border-radius:3px;}
        .form-group{margin-bottom:16px;}
        .form-label{display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;}
        .form-control{width:100%;padding:12px 16px;background:#F4F2EB;border:2px solid transparent;border-radius:var(--radius-sm);font-family:inherit;font-size:14px;color:var(--text);outline:none;transition:all .2s;}
        .form-control:focus{border-color:var(--primary);background:var(--white);}
        select.form-control{cursor:pointer;}
        textarea.form-control{resize:vertical;min-height:100px;}
        .alert{padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:14px;font-size:13px;display:flex;align-items:center;gap:10px;}
        .alert-success{background:#E8F5E9;border:1px solid #A5D6A7;color:#2E7D32;}
        .alert-danger{background:#FFEBEE;border:1px solid #EF9A9A;color:#C62828;}
        .admin-footer{display:flex;justify-content:space-between;align-items:center;padding:22px 0 0;border-top:1px solid var(--border);margin-top:28px;color:var(--text-m);font-size:12px;}
        .admin-footer a{color:var(--text-m);margin-left:14px;}
        .admin-footer a:hover{color:var(--primary);}
        .pagination{display:flex;gap:6px;align-items:center;}
        .page-btn{width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--white);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;cursor:pointer;color:var(--text-m);transition:all .2s;}
        .page-btn.active,.page-btn:hover{background:var(--primary);color:#fff;border-color:var(--primary);}
        @keyframes pulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div style="display:flex">
    <aside class="admin-sidebar">
        <div>
            <div class="admin-brand">
                <h2>RasaRekomendasi</h2>
                <p>Admin Panel</p>
            </div>
            <ul class="admin-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.recipes.index') }}" class="{{ request()->routeIs('admin.recipes.*') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Recipes</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fas fa-shapes"></i> Categories</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="{{ route('admin.moderation.index') }}" class="{{ request()->routeIs('admin.moderation.*') ? 'active' : '' }}"><i class="fas fa-comments"></i> Moderation</a></li>
                <li><a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}"><i class="fas fa-receipt"></i> Transactions</a></li>
                <li><a href="{{ route('admin.statistics') }}" class="{{ request()->routeIs('admin.statistics') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Statistics</a></li>
                <li><a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="fas fa-user-cog"></i> Profile Settings</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-admin" style="display:none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();" style="color: #C62828;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
        <div>
            <div style="padding: 0 20px; margin-bottom: 20px;">
                <div style="background:#FFF5F3; border-radius:12px; padding:12px 16px; border:1px solid #FFE0D8;">
                    <div style="font-size:10px; font-weight:700; color:#E04D2C; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">System Status</div>
                    <div style="display:flex; align-items:center; gap:6px; font-size:12px; color:#2E7D32; font-weight:600;">
                        <span style="width:6px; height:6px; background:#2E7D32; border-radius:50%; display:inline-block; animation: pulse 1.5s infinite;"></span> All systems active
                    </div>
                </div>
            </div>
            <div class="sidebar-user">
                <img src="{{ Auth::user()->avatar_url }}" alt="">
                <div><h4>{{ Auth::user()->name }}</h4><p>Manage RasaRekomendasi</p></div>
            </div>
        </div>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div class="admin-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search insights...">
            </div>
            <div class="topbar-right">
                <i class="far fa-bell" style="cursor:pointer"></i>
                <i class="far fa-heart" style="cursor:pointer"></i>
                <img src="{{ Auth::user()->avatar_url }}" alt="">
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif

        @yield('content')

        <div class="admin-footer">
            <div><a href="#">Privacy Policy</a><a href="#">Help Center</a><a href="#">System Status</a></div>
            <div>&copy; 2026 <strong style="color:var(--primary)">RasaRekomendasi</strong>. Admin Dashboard v2.4.0</div>
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
