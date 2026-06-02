<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chef Panel — @yield('title') | RasaRekomendasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{--primary:#FF5A36;--primary-h:#E04D2C;--primary-bg:#FFF0EC;--bg:linear-gradient(0deg, #FCF9F8, #FCF9F8), #FFFFFF;--white:#FFFFFF;--text:#333;--text-m:#777;--border:#EEE;--radius:16px;--radius-sm:10px;--shadow:0 4px 15px rgba(0,0,0,.04);}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Outfit',sans-serif;background:var(--bg);color:var(--text);}
        a{text-decoration:none;color:inherit;transition:color .2s;}
        .chef-sidebar{position:fixed;top:0;left:0;width:250px;height:100vh;background:var(--white);border-right:1px solid var(--border);display:flex;flex-direction:column;justify-content:space-between;z-index:100;}
        .chef-brand{padding:28px 28px 20px;}
        .chef-brand h2{font-size:20px;font-weight:800;color:var(--primary);}
        .chef-brand p{font-size:11px;color:var(--text-m);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-top:2px;}
        .chef-menu{list-style:none;}
        .chef-menu li a{display:flex;align-items:center;gap:14px;padding:13px 20px 13px 28px;font-size:14px;font-weight:500;color:#555;border-radius:0 30px 30px 0;margin-right:20px;transition:all .2s;}
        .chef-menu li a i{width:20px;text-align:center;}
        .chef-menu li a:hover,.chef-menu li a.active{background:var(--primary-bg);color:var(--primary);}
        .chef-menu li a.active{font-weight:600;box-shadow:inset -3px 0 0 var(--primary);}
        .sidebar-user{padding:16px 24px;border-top:1px solid var(--border);display:flex;align-items:center;gap:12px;}
        .sidebar-user img{width:36px;height:36px;border-radius:50%;object-fit:cover;}
        .sidebar-user h4{font-size:13px;font-weight:700;margin:0;}
        .sidebar-user p{font-size:11px;color:var(--text-m);margin:0;}
        .chef-main{margin-left:250px;min-height:100vh;padding:32px 48px;flex:1;min-width:0;}
        .chef-topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;}
        .chef-search{position:relative;}
        .chef-search i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#aaa;font-size:13px;}
        .chef-search input{padding:10px 16px 10px 38px;width:280px;background:var(--white);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:inherit;font-size:13px;outline:none;}
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
        .white-card{background:var(--white);border-radius:20px;padding:26px;box-shadow:var(--shadow);margin-bottom:24px;}
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
        .badge{padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;}
        .badge-pub, .badge-active{background:#E8F5E9;color:#2E7D32;}
        .badge-pending{background:#F3E5F5;color:#7B1FA2;}
        .td-acts{display:flex;gap:6px;}
        .tact{width:28px;height:28px;border-radius:50%;border:none;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;transition:opacity .2s;}
        .tact-edit{background:#E3F2FD;color:#1565C0;}
        .tact-del{background:#FFEBEE;color:#C62828;}
        .form-group{margin-bottom:16px;}
        .form-label{display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;}
        .form-control{width:100%;padding:12px 16px;background:#F4F2EB;border:2px solid transparent;border-radius:var(--radius-sm);font-family:inherit;font-size:14px;color:var(--text);outline:none;transition:all .2s;}
        .form-control:focus{border-color:var(--primary);background:var(--white);}
        .alert{padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:14px;font-size:13px;display:flex;align-items:center;gap:10px;}
        .alert-success{background:#E8F5E9;border:1px solid #A5D6A7;color:#2E7D32;}
        .alert-danger{background:#FFEBEE;border:1px solid #EF9A9A;color:#C62828;}
        .chef-footer{display:flex;justify-content:space-between;align-items:center;padding:22px 0 0;border-top:1px solid var(--border);margin-top:28px;color:var(--text-m);font-size:12px;}
        .chef-footer a{color:var(--text-m);margin-left:14px;}
        .chef-footer a:hover{color:var(--primary);}
    </style>
    @stack('styles')
</head>
<body>
<div style="display:flex">
    <aside class="chef-sidebar">
        <div>
            <div class="chef-brand" style="padding-bottom:14px;">
                <h2 style="font-size:24px;font-weight:800;color:var(--primary);line-height:1.2;font-family:'Outfit',sans-serif">RasaReko<br>mendasi</h2>
            </div>
            
            <!-- Chef Profile Block at the top -->
            <div style="display:flex;align-items:center;gap:12px;padding:0 28px 24px;border-bottom:1px solid var(--border);margin-bottom:20px;">
                <img src="{{ Auth::user()->avatar_url }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-bg);" alt="">
                <div>
                    <h4 style="font-size:14px;font-weight:800;color:#111;margin:0;">{{ Auth::user()->name }}</h4>
                    <p style="font-size:11px;font-weight:700;color:#777;margin-top:2px;">Chef Dashboard</p>
                    <div style="font-size:9px;color:#C87B00;font-weight:800;background:#FFF4E0;padding:2px 6px;border-radius:4px;display:inline-block;margin-top:4px;">Verified Professional</div>
                </div>
            </div>

            <ul class="chef-menu">
                <li><a href="{{ route('chef.dashboard') }}" class="{{ request()->routeIs('chef.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="{{ route('chef.schedules.index') }}" class="{{ request()->routeIs('chef.schedules.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Jadwal Konsultasi</a></li>
                <li><a href="{{ route('chef.recipes.index') }}" class="{{ request()->routeIs('chef.recipes.*') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Resep Saya</a></li>
                <li><a href="{{ route('chef.consultations.index') }}" class="{{ request()->routeIs('chef.consultations.*') && !request()->has('history') ? 'active' : '' }}"><i class="fas fa-comments"></i> Chat Konsultasi</a></li>
                <li><a href="{{ route('chef.consultations.index', ['history' => 1]) }}" class="{{ request()->has('history') ? 'active' : '' }}"><i class="fas fa-history"></i> Riwayat Chat</a></li>
                <li><a href="{{ route('chef.analytics') }}" class="{{ request()->routeIs('chef.analytics') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Analytics</a></li>
                <li><a href="{{ route('chef.earnings') }}" class="{{ request()->routeIs('chef.earnings') ? 'active' : '' }}"><i class="fas fa-wallet"></i> Earnings</a></li>
                <li><a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="fas fa-cog"></i> Settings</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-chef" style="display:none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-chef').submit();" style="color: #C62828;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
        
        <div style="padding:20px 24px;">
            <button onclick="alert('Starting live consultation broadcast...')" style="width:100%;height:46px;background:#FF5A36;color:#FFF;border:none;border-radius:24px;font-family:inherit;font-weight:700;font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 14px rgba(255,90,54,0.25);">Go Live Now</button>
        </div>
    </aside>

    <main class="chef-main">
        <div class="chef-topbar">
            <div class="chef-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search my console...">
            </div>
            <div style="display:flex;align-items:center;gap:18px;">
                <i class="far fa-bell" style="font-size:18px;color:#aaa;cursor:pointer"></i>
                <!-- VIP Badge Icon -->
                <div style="width:34px;height:34px;border-radius:50%;background:#FFF4E0;display:flex;align-items:center;justify-content:center;color:#FF9800;font-size:14px;border:1px solid #FFE0B2;cursor:pointer;">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif

        @yield('content')

        <div class="chef-footer">
            <div><a href="#">Chef Support</a><a href="#">Knowledge Base</a></div>
            <div>&copy; 2026 <strong style="color:var(--primary)">RasaRekomendasi</strong>. Chef Console v1.2.0</div>
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
