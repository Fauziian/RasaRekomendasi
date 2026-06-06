@extends('layouts.app')
@section('title', 'Cari Resep')

@push('styles')
<style>
    .wizard-container {
        max-width: 800px;
        margin: 60px auto;
        padding: 0 20px;
    }
    .wizard-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .wizard-header h1 {
        font-size: 34px;
        font-weight: 800;
        color: #111;
        font-family: 'Outfit', sans-serif;
    }
    .wizard-header p {
        font-size: 15px;
        color: #777;
        margin-top: 8px;
    }

    /* Section blocks */
    .wizard-section {
        margin-bottom: 36px;
    }
    .section-title {
        font-size: 14px;
        font-weight: 800;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .section-title i {
        color: #A03010;
    }

    /* Option Pill grids */
    .pills-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pill-checkbox-label {
        padding: 10px 24px;
        border-radius: 24px;
        background: #FFF;
        border: 1.5px solid #EAE6DF;
        color: #333;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        user-select: none;
    }
    .pill-checkbox-input {
        display: none;
    }
    .pill-checkbox-input:checked + .pill-checkbox-label {
        background: #FFF0EC;
        border-color: #FF5A36;
        color: #FF5A36;
    }

    /* Difficulty emoji block cards */
    .diff-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .diff-card-label {
        background: #FFF;
        border: 1.5px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        user-select: none;
    }
    .diff-card-input {
        display: none;
    }
    .diff-card-input:checked + .diff-card-label {
        background: #FFF0EC;
        border-color: #FF5A36;
        color: #FF5A36;
        box-shadow: 0 8px 24px rgba(255,90,54,0.06);
    }
    .diff-card-label .emoji-ico {
        font-size: 24px;
    }

    /* Submit Button custom figma style */
    .btn-tampilkan-rekomendasi {
        width: 100%;
        padding: 16px;
        border-radius: 30px;
        background: #A03010;
        color: #FFF;
        font-weight: 700;
        font-size: 16px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.2s;
        margin-top: 40px;
        box-shadow: 0 10px 24px rgba(160,48,16,0.15);
    }
    .btn-tampilkan-rekomendasi:hover {
        background: #802008;
    }
</style>
@endpush

@section('content')
<div class="wizard-container">
    <div class="wizard-header">
        <h1>Cari Resep Berdasarkan Preferensimu</h1>
        <p>Personalisasi pengalaman memasakmu agar sesuai dengan selera hari ini.</p>
    </div>

    <form method="POST" action="{{ route('recommendations.submit') }}">
        @csrf

        <!-- Section 1: Kategori Masakan -->
        <div class="wizard-section">
            <h3 class="section-title"><i class="fas fa-utensils"></i> Kategori Masakan</h3>
            <div class="pills-grid">
                <!-- Checkboxes serving as key ingredients -->
                <input type="checkbox" name="ingredients[]" value="Western" id="cat-western" class="pill-checkbox-input">
                <label for="cat-western" class="pill-checkbox-label">Western</label>

                <input type="checkbox" name="ingredients[]" value="Asia" id="cat-asia" class="pill-checkbox-input" checked>
                <label for="cat-asia" class="pill-checkbox-label">Asia</label>

                <input type="checkbox" name="ingredients[]" value="Indonesia" id="cat-indonesia" class="pill-checkbox-input" checked>
                <label for="cat-indonesia" class="pill-checkbox-label">Tradisional Indonesia</label>
            </div>
        </div>

        <!-- Section 2: Profil Rasa -->
        <div class="wizard-section">
            <h3 class="section-title"><i class="fas fa-pepper-hot"></i> Profil Rasa</h3>
            <div class="pills-grid">
                <input type="checkbox" name="ingredients[]" value="Pedas" id="flavor-pedas" class="pill-checkbox-input" checked>
                <label for="flavor-pedas" class="pill-checkbox-label">Pedas</label>

                <input type="checkbox" name="ingredients[]" value="Manis" id="flavor-manis" class="pill-checkbox-input">
                <label for="flavor-manis" class="pill-checkbox-label">Manis</label>

                <input type="checkbox" name="ingredients[]" value="Gurih" id="flavor-gurih" class="pill-checkbox-input" checked>
                <label for="flavor-gurih" class="pill-checkbox-label">Gurih</label>

                <input type="checkbox" name="ingredients[]" value="Asin" id="flavor-asin" class="pill-checkbox-input">
                <label for="flavor-asin" class="pill-checkbox-label">Asin</label>

                <input type="checkbox" name="ingredients[]" value="Segar" id="flavor-segar" class="pill-checkbox-input">
                <label for="flavor-segar" class="pill-checkbox-label">Segar</label>
            </div>
        </div>

        <!-- Section 3: Tingkat Kesulitan -->
        <div class="wizard-section">
            <h3 class="section-title"><i class="fas fa-signal"></i> Tingkat Kesulitan</h3>
            <div class="diff-cards-grid">
                <!-- Radio Easy -->
                <input type="radio" name="difficulty" value="easy" id="diff-easy" class="diff-card-input" checked>
                <label for="diff-easy" class="diff-card-label">
                    <span class="emoji-ico">😊</span>
                    <strong style="font-size:13px; font-weight:800;">Mudah</strong>
                </label>

                <!-- Radio Medium -->
                <input type="radio" name="difficulty" value="medium" id="diff-medium" class="diff-card-input">
                <label for="diff-medium" class="diff-card-label">
                    <span class="emoji-ico">😐</span>
                    <strong style="font-size:13px; font-weight:800;">Sedang</strong>
                </label>

                <!-- Radio Hard -->
                <input type="radio" name="difficulty" value="hard" id="diff-hard" class="diff-card-input">
                <label for="diff-hard" class="diff-card-label">
                    <span class="emoji-ico">📈</span>
                    <strong style="font-size:13px; font-weight:800;">Sulit</strong>
                </label>
            </div>
        </div>

        <!-- Section 4: Waktu Masak Maksimal -->
        <div class="wizard-section">
            <h3 class="section-title"><i class="far fa-clock"></i> Waktu Masak Maksimal</h3>
            <div class="pills-grid">
                <input type="radio" name="max_time" value="15" id="time-15" class="pill-checkbox-input">
                <label for="time-15" class="pill-checkbox-label">15 m</label>

                <input type="radio" name="max_time" value="30" id="time-30" class="pill-checkbox-input" checked>
                <label for="time-30" class="pill-checkbox-label">30 m</label>

                <input type="radio" name="max_time" value="60" id="time-60" class="pill-checkbox-input">
                <label for="time-60" class="pill-checkbox-label">60 m</label>

                <input type="radio" name="max_time" value="120" id="time-120" class="pill-checkbox-input">
                <label for="time-120" class="pill-checkbox-label">> 60 m</label>
            </div>
        </div>

        <!-- Submit -->
        @auth
            <button type="submit" class="btn-tampilkan-rekomendasi">
                <i class="fas fa-magic"></i> Tampilkan Rekomendasi
            </button>
        @else
            {{-- Guest: tidak bisa submit, arahkan ke login --}}
            <a href="{{ route('login') }}" class="btn-tampilkan-rekomendasi" style="text-decoration:none; margin-top:40px;">
                <i class="fas fa-lock"></i> Login untuk Tampilkan Rekomendasi
            </a>
            <p style="text-align:center; font-size:12px; color:#999; margin-top:12px;">
                Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--primary); font-weight:700;">Masuk di sini</a> &nbsp;·&nbsp;
                Belum punya akun? <a href="{{ route('register') }}" style="color:var(--primary); font-weight:700;">Daftar gratis</a>
            </p>
        @endauth
    </form>
</div>
@endsection
