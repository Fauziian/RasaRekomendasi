@extends('layouts.chef')
@section('title', isset($recipe) ? 'Edit Resep' : 'Tambah Resep')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <div>
        <h1 style="font-size:26px;font-weight:700;color:#111">{{ isset($recipe) ? 'Edit Resep' : 'Tambah Resep Baru' }}</h1>
        <p style="color:var(--text-m);margin-top:3px">Detail resep masakan Anda.</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('chef.recipes.index') }}" class="btn btn-white btn-sm">Batal</a>
        <button type="submit" form="recipeForm" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
    </div>
</div>

<form id="recipeForm" method="POST" action="{{ isset($recipe) ? route('chef.recipes.update',$recipe) : route('chef.recipes.store') }}">
    @csrf
    @if(isset($recipe)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:22px">
        <div>
            <div class="white-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:18px">Informasi Utama</h3>
                <div class="form-group">
                    <label class="form-label">JUDUL RESEP</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Nasi Goreng Gila Pedas" value="{{ old('title',$recipe->title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">DESKRIPSI</label>
                    <textarea name="description" class="form-control" placeholder="Ceritakan sejarah atau rasa masakan ini..." rows="3">{{ old('description',$recipe->description ?? '') }}</textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                    <div class="form-group">
                        <label class="form-label">KATEGORI</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id',($recipe->category_id ?? '')) == $cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">TINGKAT KESULITAN</label>
                        <select name="difficulty" class="form-control" required>
                            @foreach(['easy'=>'Mudah','medium'=>'Sedang','hard'=>'Sulit'] as $v=>$l)
                                <option value="{{ $v }}" {{ old('difficulty',($recipe->difficulty ?? '')) == $v ? 'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px">
                    <div class="form-group">
                        <label class="form-label">PERSIAPAN (MENIT)</label>
                        <input type="number" name="prep_time" class="form-control" value="{{ old('prep_time',$recipe->prep_time ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">MASAK (MENIT)</label>
                        <input type="number" name="cook_time" class="form-control" value="{{ old('cook_time',$recipe->cook_time ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">KALORI (KCAL)</label>
                        <input type="number" name="calories" class="form-control" value="{{ old('calories',$recipe->calories ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="white-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:18px">Bahan-Bahan</h3>
                <div id="ingredientsList">
                    @if(isset($recipe) && $recipe->ingredients)
                        @foreach($recipe->ingredients as $i => $ing)
                        <div style="display:grid;grid-template-columns:1fr auto auto;gap:10px;margin-bottom:10px;align-items:center">
                            <input type="text" name="ingredients[{{ $i }}][name]" class="form-control" value="{{ $ing['name'] ?? '' }}" placeholder="Nama Bahan">
                            <input type="text" name="ingredients[{{ $i }}][amount]" class="form-control" value="{{ $ing['amount'] ?? '' }}" placeholder="Jumlah" style="width:80px">
                            <input type="text" name="ingredients[{{ $i }}][unit]" class="form-control" value="{{ $ing['unit'] ?? '' }}" placeholder="Satuan" style="width:80px">
                        </div>
                        @endforeach
                    @else
                        <div style="display:grid;grid-template-columns:1fr auto auto;gap:10px;margin-bottom:10px;align-items:center">
                            <input type="text" name="ingredients[0][name]" class="form-control" placeholder="Nama Bahan">
                            <input type="text" name="ingredients[0][amount]" class="form-control" placeholder="Jumlah" style="width:80px">
                            <input type="text" name="ingredients[0][unit]" class="form-control" placeholder="Satuan" style="width:80px">
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addIngredient()" class="btn btn-white btn-sm"><i class="fas fa-plus"></i> Tambah Bahan</button>
            </div>
        </div>

        <div>
            <div class="white-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:16px">Pengaturan Resep</h3>
                <div class="form-group">
                    <label class="form-label">STATUS</label>
                    <select name="status" class="form-control">
                        <option value="published" {{ old('status',($recipe->status ?? '')) == 'published' ? 'selected':'' }}>Published</option>
                        <option value="draft" {{ old('status',($recipe->status ?? '')) == 'draft' ? 'selected':'' }}>Draft</option>
                    </select>
                </div>
                <div style="display:flex;align-items:center;gap:10px;padding:12px 0;border-top:1px solid var(--border)">
                    <input type="checkbox" name="is_vip_content" id="vipCheck" value="1" style="accent-color:var(--primary);width:18px;height:18px" {{ old('is_vip_content',($recipe->is_vip_content ?? false)) ? 'checked':'' }}>
                    <label for="vipCheck" style="font-size:14px;font-weight:600;cursor:pointer"><i class="fas fa-crown" style="color:#FFD700"></i> Konten VIP</label>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
let ingCount = {{ isset($recipe) && $recipe->ingredients ? count($recipe->ingredients) : 1 }};
function addIngredient() {
    document.getElementById('ingredientsList').insertAdjacentHTML('beforeend',
        `<div style="display:grid;grid-template-columns:1fr auto auto;gap:10px;margin-bottom:10px;align-items:center">
            <input type="text" name="ingredients[${ingCount}][name]" class="form-control" placeholder="Nama Bahan">
            <input type="text" name="ingredients[${ingCount}][amount]" class="form-control" placeholder="Jumlah" style="width:80px">
            <input type="text" name="ingredients[${ingCount}][unit]" class="form-control" placeholder="Satuan" style="width:80px">
        </div>`);
    ingCount++;
}
</script>
@endpush
@endsection
