@extends('layouts.app')
@section('title', 'Masuk')

@push('styles')
<style>
    .login-container {
        min-height: calc(100vh - 68px);
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        background: #FFF;
    }

    /* Left panel: Culinary cover overlay */
    .login-cover {
        background: linear-gradient(rgba(255, 90, 54, 0.72), rgba(224, 77, 44, 0.72)), 
                    url('https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=1200') center/cover no-repeat;
        color: #FFF;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 60px;
        position: relative;
    }
    .cover-icon-box {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1.5px solid rgba(255,255,255,0.4);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 24px;
    }
    .cover-h1 {
        font-size: 38px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 12px;
        font-family: 'Outfit', sans-serif;
    }
    .cover-desc {
        font-size: 15px;
        opacity: 0.9;
        max-width: 360px;
        line-height: 1.6;
    }

    /* Right panel: Login form */
    .login-form-area {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 60px 40px;
        background: #FAF9F6;
    }
    .login-card {
        background: #FFF;
        border-radius: 24px;
        border: 1px solid #EAE6DF;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        padding: 44px;
        width: 100%;
        max-width: 460px;
    }
    .input-icon-wrap {
        position: relative;
    }
    .input-icon-wrap i.left-ico {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 14px;
    }
    .input-field-custom {
        width: 100%;
        padding: 14px 16px 14px 44px;
        border-radius: 12px;
        border: 1.5px solid #EAE6DF;
        background: #FAF9F6;
        font-family: inherit;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: all 0.2s;
    }
    .input-field-custom:focus {
        border-color: var(--primary);
        background: #FFF;
    }
    .toggle-pass-custom {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-masuk {
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        background: #A03010; /* Rich figma brown accent */
        color: #FFF;
        font-weight: 700;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }
    .btn-masuk:hover {
        background: #802008;
    }

    /* Google Button */
    .btn-google {
        width: 100%;
        padding: 13px;
        border-radius: 12px;
        background: #FFF;
        border: 1.5px solid #EAE6DF;
        color: #333;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.2s;
    }
    .btn-google:hover {
        background: #FAF9F6;
    }

    /* Quick Login Utilities */
    .quick-bar {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 14px;
    }
    .quick-chip {
        padding: 10px;
        border-radius: 10px;
        background: #FAF9F6;
        border: 1px solid #EAE6DF;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s;
    }
    .quick-chip:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: #FFF0EC;
    }

    @media (max-width: 768px) {
        .login-container { grid-template-columns: 1fr; }
        .login-cover { display: none; }
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <!-- Left panel (cover photo) -->
    <div class="login-cover">
        <div class="cover-icon-box">
            <i class="fas fa-utensils"></i>
        </div>
        <h1 class="cover-h1">Masak Seru, Rasa Juara</h1>
        <p class="cover-desc">Temukan ribuan inspirasi resep rumahan yang lezat dan mudah dibuat setiap hari.</p>
    </div>

    <!-- Right panel (form area) -->
    <div class="login-form-area">
        <div class="login-card">
            <h2 style="font-size: 26px; font-weight: 800; color: #111; text-align: center; font-family: 'Outfit', sans-serif;">RasaRekomendasi</h2>
            <p style="font-size: 13px; color: #777; text-align: center; margin-top: 4px; margin-bottom: 32px;">Selamat datang kembali! Silakan masuk ke akun Anda.</p>

            @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" style="display:flex; flex-direction:column; gap:20px;">
                @csrf
                
                <!-- Email field -->
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-size:12px; font-weight:700; color:#555; text-transform:uppercase; letter-spacing:0.5px;">Email</label>
                    <div class="input-icon-wrap">
                        <i class="far fa-envelope left-ico"></i>
                        <input type="email" name="email" class="input-field-custom" placeholder="nama@email.com" id="emailInput" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <!-- Password field -->
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <label style="font-size:12px; font-weight:700; color:#555; text-transform:uppercase; letter-spacing:0.5px;">Password</label>
                        <a href="#" style="font-size:12px; color:#A03010; font-weight:700;">Lupa Password?</a>
                    </div>
                    <div class="input-icon-wrap">
                        <i class="fas fa-lock left-ico"></i>
                        <input type="password" name="password" class="input-field-custom" placeholder="••••••••" id="passInput" required>
                        <button type="button" class="toggle-pass-custom" onclick="togglePass()">
                            <i class="far fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember switch -->
                <div style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" name="remember" id="remember" style="accent-color:var(--primary);">
                    <label for="remember" style="font-size:13px; color:#666; cursor:pointer;">Ingat saya</label>
                </div>

                <button type="submit" class="btn-masuk">
                    Masuk
                </button>
            </form>

            <div style="display:flex; align-items:center; gap:12px; margin: 24px 0; color:#aaa; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">
                <div style="flex:1; height:1px; background:#EAE6DF;"></div>
                <span>atau masuk dengan</span>
                <div style="flex:1; height:1px; background:#EAE6DF;"></div>
            </div>

            <!-- Google button -->
            <button class="btn-google">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" style="width:16px; height:16px;" alt="">
                Google
            </button>

            <!-- Quick login helper -->
            <div style="margin-top: 24px; padding-top: 20px; border-top:1px solid #EAE6DF;">
                <p style="font-size:11px; color:#999; text-align:center; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Developer Quick Login</p>
                <div class="quick-bar">
                    <div class="quick-chip" onclick="quickLogin('admin@rasarekomendasi.id','password')"><i class="fas fa-shield-alt" style="color:#A03010"></i> Admin</div>
                    <div class="quick-chip" onclick="quickLogin('chef.rina@rasarekomendasi.id','password')"><i class="fas fa-utensils" style="color:#2E7D32"></i> Chef</div>
                    <div class="quick-chip" onclick="quickLogin('budi.santoso@gmail.com','password')"><i class="fas fa-user" style="color:#1565C0"></i> User</div>
                </div>
            </div>

            <p style="font-size:13px; text-align:center; color:#555; margin-top:24px;">Belum punya akun? <a href="{{ route('register') }}" style="color:#A03010; font-weight:700;">Daftar</a></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePass() {
    const i = document.getElementById('passInput');
    const icon = document.getElementById('eyeIcon');
    i.type = i.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}
function quickLogin(email, pass) {
    document.getElementById('emailInput').value = email;
    document.getElementById('passInput').value = pass;
    document.getElementById('loginForm').submit();
}
</script>
@endpush
