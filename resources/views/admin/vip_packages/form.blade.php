@extends('layouts.admin')
@section('title', $package ? 'Edit Paket VIP' : 'Tambah Paket VIP')
@section('content')
<div style="padding:30px;max-width:640px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('admin.vip-packages.index') }}" style="font-size:13px;color:var(--primary);text-decoration:none;">← Kembali</a>
        <h1 style="font-size:24px;font-weight:800;margin-top:10px;">{{ $package ? 'Edit Paket VIP' : 'Tambah Paket VIP' }}</h1>
    </div>

    <form method="POST" 
          action="{{ $package ? route('admin.vip-packages.update', $package) : route('admin.vip-packages.store') }}" 
          class="card" style="padding:30px;border:none;box-shadow:var(--shadow-lg);">
        @csrf
        @if($package) @method('PUT') @endif

        @if($errors->any())
        <div style="background:#FEE2E2;border:1px solid #FECACA;padding:14px;border-radius:8px;margin-bottom:20px;font-size:13px;color:#991B1B;">
            <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="form-group" style="margin-bottom:20px;">
            <label class="form-label">Nama Paket <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $package?->name) }}" required placeholder="contoh: VIP Gold 30 Hari">
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
            <div class="form-group">
                <label class="form-label">Harga (Rp) <span style="color:red">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $package?->price) }}" required min="0" placeholder="99000">
            </div>
            <div class="form-group">
                <label class="form-label">Durasi (hari) <span style="color:red">*</span></label>
                <input type="number" name="duration_days" class="form-control" value="{{ old('duration_days', $package?->duration_days) }}" required min="1" placeholder="30">
            </div>
        </div>

        <div class="form-group" style="margin-bottom:20px;">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat paket VIP ini...">{{ old('description', $package?->description) }}</textarea>
        </div>

        <div class="form-group" style="margin-bottom:24px;">
            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package?->is_active ?? true) ? 'checked' : '' }}>
                <span style="font-size:14px;font-weight:600;">Aktifkan paket ini (tampil di halaman VIP)</span>
            </label>
        </div>

        <button type="submit" class="btn" style="width:100%;justify-content:center;">
            <i class="fas fa-save"></i> {{ $package ? 'Simpan Perubahan' : 'Tambah Paket' }}
        </button>
    </form>
</div>
@endsection
