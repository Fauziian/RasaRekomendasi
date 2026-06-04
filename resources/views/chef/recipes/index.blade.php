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

<div class="white-card">
    <table>
        <thead><tr><th>NAMA RESEP</th><th>KATEGORI</th><th>WAKTU MASAK</th><th>LEVEL</th><th>STATUS</th><th>RATING</th><th>AKSI</th></tr></thead>
        <tbody>
        @forelse($recipes as $recipe)
        <tr>
            <td>
                <div class="td-img">
                    <img src="https://source.unsplash.com/100x100/?{{ urlencode($recipe->title) }},food" alt="">
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
                    <form method="POST" action="{{ route('chef.recipes.destroy',$recipe) }}" onsubmit="return confirm('Hapus resep ini?')">
                        @csrf @method('DELETE')
                        <button class="tact tact-del"><i class="fas fa-trash"></i></button>
                    </form>
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
@endsection
