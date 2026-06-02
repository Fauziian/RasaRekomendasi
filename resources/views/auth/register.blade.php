@extends('layouts.app')
@section('title', 'Daftar - RasaRekomendasi')

@push('styles')
<style>
    /* Premium Figma signup styles */
    .register-body {
        background: linear-gradient(0deg, #FCF9F8, #FCF9F8), #FFFFFF;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 20px;
    }
    .register-card {
        background: #FFF;
        width: 100%;
        max-width: 480px;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.03);
        overflow: hidden;
        border: 1px solid #EAE6DF;
    }
    
    /* Header section with soft gradient */
    .register-header {
        background: linear-gradient(to bottom, #E0ECE9 0%, #FFFFFF 100%);
        padding: 40px 30px 20px 30px;
        text-align: center;
        position: relative;
    }
    .register-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #FF5A36;
        margin-bottom: 6px;
        font-family: 'Outfit', sans-serif;
    }
    .register-header p {
        font-size: 13px;
        color: #777;
        margin: 0;
    }

    /* Dashed upload circle */
    .avatar-upload-container {
        display: flex;
        justify-content: center;
        margin-top: -15px;
        margin-bottom: 25px;
        position: relative;
    }
    .avatar-preview-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px dashed #D0C9C0;
        background: #FAF8F5;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .avatar-preview-circle:hover {
        border-color: #FF5A36;
    }
    .avatar-preview-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }
    .avatar-preview-circle i {
        font-size: 24px;
        color: #A09A90;
        z-index: 1;
    }

    /* Forms */
    .register-form {
        padding: 0 40px 40px 40px;
    }
    .register-label {
        font-size: 11px;
        font-weight: 700;
        color: #5D4037;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .register-input-wrap {
        position: relative;
        margin-bottom: 20px;
    }
    .register-input-wrap i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #A09890;
        font-size: 13px;
    }
    .register-input {
        width: 100%;
        padding: 14px 16px 14px 44px;
        border: 1.5px solid #EAE6DF;
        border-radius: 12px;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        background: #FAF9F6;
        transition: all 0.2s;
        color: #333;
    }
    .register-input:focus {
        border-color: #FF5A36;
        background: #FFF;
        box-shadow: 0 4px 12px rgba(255, 90, 54, 0.05);
    }
    .register-input::placeholder {
        color: #A5A098;
    }

    /* Checkbox terms */
    .terms-label {
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        line-height: 1.4;
        cursor: pointer;
        margin-bottom: 24px;
    }
    .terms-label input {
        margin-top: 3px;
        width: 16px;
        height: 16px;
        accent-color: #FF5A36;
    }

    /* Action button */
    .btn-register-submit {
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        background: #FF5A36;
        color: #FFF;
        font-weight: 700;
        font-size: 14px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 6px 16px rgba(255, 90, 54, 0.2);
        transition: all 0.2s;
    }
    .btn-register-submit:hover {
        background: #E04D2C;
        transform: translateY(-1px);
    }

    /* Divider */
    .register-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 24px 0;
        color: #C0B9B0;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .register-divider::before, .register-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1.5px solid #F0ECE6;
    }
    .register-divider:not(:empty)::before {
        margin-right: 1.5em;
    }
    .register-divider:not(:empty)::after {
        margin-left: 1.5em;
    }
</style>
@endpush

@section('content')
<div class="register-body">
    <div class="register-card">
        
        <!-- Gradient header title -->
        <div class="register-header">
            <h2>Daftar Sekarang</h2>
            <p>Mulai petualangan rasa Anda hari ini</p>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="register-form">
            @csrf

            <!-- Upload Photo Circle -->
            <div class="avatar-upload-container">
                <div class="avatar-preview-circle" onclick="triggerAvatarSelect()">
                    <i class="fas fa-camera" id="cameraIcon"></i>
                    <img id="avatarPreview" src="" style="display: none;" alt="Preview">
                </div>
                <input type="file" name="avatar" id="avatarInput" style="display: none;" accept="image/*" onchange="previewSelectedImage(this)">
            </div>

            <!-- Error Validation List -->
            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px; font-size:12px; padding:10px 14px;">
                    <ul style="margin: 0; padding-left: 15px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Full Name -->
            <div class="register-label"><i class="fas fa-user-circle"></i> Nama Lengkap</div>
            <div class="register-input-wrap">
                <i class="fas fa-user"></i>
                <input type="text" name="name" class="register-input" placeholder="Indra Wijaya" value="{{ old('name') }}" required autofocus>
            </div>

            <!-- Email Address -->
            <div class="register-label"><i class="fas fa-envelope-open"></i> Alamat Email</div>
            <div class="register-input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" class="register-input" placeholder="indra@rasarekomendasi.com" value="{{ old('email') }}" required>
            </div>

            <!-- Password -->
            <div class="register-label"><i class="fas fa-lock"></i> Kata Sandi</div>
            <div class="register-input-wrap">
                <i class="fas fa-key"></i>
                <input type="password" name="password" class="register-input" placeholder="••••••••" required autocomplete="new-password">
            </div>

            <!-- Confirm Password -->
            <div class="register-label"><i class="fas fa-shield-alt"></i> Konfirmasi Kata Sandi</div>
            <div class="register-input-wrap">
                <i class="fas fa-check-double"></i>
                <input type="password" name="password_confirmation" class="register-input" placeholder="••••••••" required autocomplete="new-password">
            </div>

            <!-- Terms Checkbox -->
            <label class="terms-label">
                <input type="checkbox" name="terms" required>
                <span>Saya setuju dengan <a href="#" style="color:#FF5A36; font-weight:700; text-decoration:none;">Syarat dan Ketentuan</a> serta <a href="#" style="color:#FF5A36; font-weight:700; text-decoration:none;">Kebijakan Privasi</a></span>
            </label>

            <!-- Submit Button -->
            <button type="submit" class="btn-register-submit">
                Daftar <i class="fas fa-chevron-right" style="font-size: 11px;"></i>
            </button>

            <!-- Divider -->
            <div class="register-divider">SUDAH JADI CHEF?</div>

            <!-- Already Registered -->
            <p style="font-size:13px; text-align:center; color:#555; margin:0;">
                Sudah punya akun? <a href="{{ route('login') }}" style="color:#FF5A36; font-weight:800; text-decoration:none;">Masuk</a>
            </p>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function triggerAvatarSelect() {
    document.getElementById('avatarInput').click();
}

function previewSelectedImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const icon = document.getElementById('cameraIcon');
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
