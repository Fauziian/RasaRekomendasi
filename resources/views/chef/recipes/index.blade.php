@extends('layouts.chef')
@section('title','Resep Saya')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:26px">
    <div>
        <h1 style="font-size:28px;font-weight:700;color:#111">Resep Saya</h1>
        <p style="color:var(--text-m);margin-top:4px">Kelola dan publikasikan resep kreasi terbaik Anda.</p>
    </div>
    <a href="{{ route('chef.recipes.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Resep</a>
</div>

{{-- Hidden delete form --}}
<form id="delete-recipe-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

{{-- Confirmation Modal --}}
<div id="delete-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;padding:32px;max-width:380px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:56px;height:56px;background:#FFEBEE;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:24px;color:#C62828;">
            <i class="fas fa-trash"></i>
        </div>
        <h3 style="font-size:18px;font-weight:800;color:#111;margin-bottom:8px;">Hapus Resep?</h3>
        <p style="font-size:13px;color:#777;margin-bottom:24px;" id="delete-modal-name">Apakah kamu yakin ingin menghapus resep ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="closeDeleteModal()" style="padding:10px 24px;border-radius:10px;border:1px solid #EEE;background:#fff;font-family:inherit;font-size:13px;font-weight:600;cursor:pointer;color:#555;">Batal</button>
            <button onclick="confirmDelete()" style="padding:10px 24px;border-radius:10px;border:none;background:#C62828;color:#fff;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;">Ya, Hapus</button>
        </div>
    </div>
</div>

<div class="white-card">
    <table>
        <thead><tr><th>NAMA RESEP</th><th>KATEGORI</th><th>WAKTU MASAK</th><th>LEVEL</th><th>STATUS</th><th>RATING</th><th>AKSI</th></tr></thead>
        <tbody>
        @forelse($recipes as $recipe)
        <tr>
            <td>
                <div class="td-img">
                    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                    <div><h4>{{ $recipe->title }}</h4><p>Dibuat: {{ $recipe->created_at->format('M d, Y') }}</p></div>
                </div>
            </td>
            <td>{{ $recipe->category->name ?? '-' }}</td>
            <td>{{ $recipe->total_time }} min</td>
            <td>{{ ucfirst($recipe->difficulty) }}</td>
            <td>
                <span class="badge {{ $recipe->status == 'published' ? 'badge-pub' : 'badge-pending' }}">{{ ucfirst($recipe->status) }}</span>
                @if($recipe->is_vip_content)<span class="badge" style="background:#FFF9C4;color:#7c5b00;margin-left:4px;">VIP</span>@endif
            </td>
            <td style="color:#FFA500;font-weight:700;"><i class="fas fa-star"></i> {{ number_format($recipe->rating_avg, 1) }}</td>
            <td>
                <div class="td-acts">
                    <a href="{{ route('chef.recipes.edit',$recipe) }}" class="tact tact-edit"><i class="fas fa-pencil"></i></a>
                    <button type="button" class="tact tact-del"
                        onclick="openDeleteModal('{{ route('chef.recipes.destroy',$recipe) }}', '{{ addslashes($recipe->title) }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-m)">Belum ada resep.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        {{ $recipes->links() }}
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(action, name) {
    document.getElementById('delete-recipe-form').action = action;
    document.getElementById('delete-modal-name').textContent = 'Hapus "' + name + '"? Tindakan ini tidak dapat dibatalkan.';
    document.getElementById('delete-modal').style.display = 'flex';
}
function closeDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
}
function confirmDelete() {
    document.getElementById('delete-recipe-form').submit();
}
// Close modal on backdrop click
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endpush

@endsection
