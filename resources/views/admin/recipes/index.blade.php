@extends('layouts.admin')
@section('title','Recipe Management')

@section('content')
<!-- Header Row -->
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:28px">
    <div>
        <h1 style="font-size:32px;font-weight:700;color:#111;font-family:'Outfit',sans-serif">Recipe Management</h1>
        <p style="color:var(--text-m);margin-top:4px">Review, update, and manage your culinary database.</p>
    </div>
    <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary" style="background:#A03010;border:none;font-size:13px;padding:10px 20px;"><i class="fas fa-plus"></i> Add New Recipe</a>
</div>

<!-- Three Metric Cards -->
<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;margin-bottom:28px">
    <!-- Total Recipes -->
    <div class="white-card" style="padding:22px;border-radius:16px;display:flex;justify-content:space-between;align-items:center;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Total Recipes</div>
            <div style="font-size:32px;font-weight:800;color:#111;margin-top:4px;">{{ $recipes->total() }}</div>
        </div>
        <div style="width:48px;height:48px;background:#FFF0EC;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary);">
            <i class="fas fa-book-open"></i>
        </div>
    </div>

    <!-- Average Rating -->
    <div class="white-card" style="padding:22px;border-radius:16px;display:flex;justify-content:space-between;align-items:center;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Average Rating</div>
            <div style="font-size:32px;font-weight:800;color:#FF9800;margin-top:4px;display:flex;align-items:center;gap:6px;">
                4.8 <span style="font-size:20px;margin-bottom:4px;">★</span>
            </div>
        </div>
        <div style="width:48px;height:48px;background:#FFF9EF;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#FF9800;">
            <i class="fas fa-star"></i>
        </div>
    </div>

    <!-- New This Week -->
    <div class="white-card" style="padding:22px;border-radius:16px;display:flex;justify-content:space-between;align-items:center;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">New This Week</div>
            <div style="font-size:32px;font-weight:800;color:#2E7D32;margin-top:4px;">+24</div>
        </div>
        <div style="width:48px;height:48px;background:#E8F5E9;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#2E7D32;">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>
</div>

<!-- Table Container Card -->
<div class="white-card" style="border-radius:16px;padding:26px;">
    <!-- Modern Search / Filter Panel -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
        <form method="GET" style="display:flex;gap:12px;align-items:center;width:100%;max-width:320px;">
            <div style="position:relative;width:100%;">
                <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#aaa;font-size:13px"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or category..." style="width:100%;padding:10px 16px 10px 38px;border:1px solid #EEE;border-radius:10px;font-family:inherit;font-size:13px;outline:none;background:#F8F9FA;">
            </div>
        </form>
        
        <div style="display:flex;gap:8px;">
            <button class="btn btn-white" style="border-radius:10px;padding:8px 12px;font-size:13px;color:#777;"><i class="fas fa-sliders-h"></i></button>
            <button class="btn btn-white" style="border-radius:10px;padding:8px 12px;font-size:13px;color:#777;"><i class="fas fa-list"></i></button>
        </div>
    </div>

    <!-- Table -->
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="width:320px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Title</th>
                <th style="width:180px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Category</th>
                <th style="width:120px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Rating</th>
                <th style="width:160px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Date Added</th>
                <th style="width:120px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($recipes as $recipe)
        <tr>
            <td style="padding:14px 0;vertical-align:middle;">
                <div class="td-img" style="display:flex;align-items:center;gap:12px;">
                    <img src="https://placehold.co/100x100/FFF0EC/FF5A36?text={{ urlencode(Str::limit($recipe->title, 10)) }}" style="width:44px;height:44px;border-radius:10px;object-fit:cover;" alt="">
                    <div>
                        <h4 style="font-size:14px;font-weight:700;color:#111;margin:0;">{{ $recipe->title }}</h4>
                        <p style="font-size:12px;color:var(--text-m);margin:2px 0 0 0;">{{ ucfirst($recipe->difficulty) }} • {{ $recipe->prep_time }} mins</p>
                    </div>
                </div>
            </td>
            <td style="padding:14px 0;vertical-align:middle;">
                @php
                    $catColors = [
                        'sarapan' => ['#FFF0EC', '#FF5A36'],
                        'vegetarian & vegan' => ['#E8F5E9', '#2E7D32'],
                        'makanan sehat' => ['#E8F5E9', '#2E7D32'],
                        'masakan indonesia' => ['#FFF9EF', '#FF9800'],
                        'masakan asia' => ['#F3E5F5', '#7B1FA2'],
                        'masakan barat' => ['#E2F1E7', '#1B5E20'],
                        'dessert & kue' => ['#FCE4EC', '#C2185B'],
                        'minuman' => ['#E0F7FA', '#00838F'],
                        'makanan bayi' => ['#E0F2F1', '#00695C'],
                        'seafood' => ['#E8EAF6', '#283593'],
                    ];
                    $catName = strtolower($recipe->category->name ?? '');
                    $color = $catColors[$catName] ?? ['#E3F2FD', '#1565C0'];
                @endphp
                <span class="badge" style="background:{{ $color[0] }};color:{{ $color[1] }};font-size:11px;font-weight:700;padding:6px 12px;border-radius:20px;">
                    {{ $recipe->category->name ?? 'Uncategorized' }}
                </span>
            </td>
            <td style="padding:14px 0;vertical-align:middle;font-size:13px;font-weight:700;color:#111;">
                <span style="color:#FF9800;margin-right:2px;">★</span> {{ number_format($recipe->rating_avg ?? 4.8, 1) }}
            </td>
            <td style="padding:14px 0;vertical-align:middle;color:var(--text-m);font-size:13px;">
                {{ $recipe->created_at->format('M d, Y') }}
            </td>
            <td style="padding:14px 0;vertical-align:middle;text-align:right;">
                <div style="display:inline-flex;gap:12px;align-items:center;">
                    <a href="{{ route('admin.recipes.edit',$recipe) }}" style="color:#A0A0A0;font-size:15px;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#FF5A36'" onmouseout="this.style.color='#A0A0A0'" title="Edit Recipe">
                        <i class="far fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.recipes.destroy',$recipe) }}" onsubmit="return confirm('Hapus resep ini?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button style="border:none;background:transparent;color:#A0A0A0;font-size:15px;cursor:pointer;padding:0;transition:color 0.2s;" onmouseover="this.style.color='#C62828'" onmouseout="this.style.color='#A0A0A0'" title="Delete Recipe">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;padding:40px;color:var(--text-m)">Tidak ada resep ditemukan.</td>
        </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Pagination Footer -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;padding-top:16px;border-top:1px solid #F8F9FA">
        <span style="font-size:13px;color:var(--text-m)">Showing {{ $recipes->firstItem() }}–{{ $recipes->lastItem() }} of {{ $recipes->total() }} recipes</span>
        <div class="pagination">
            @if($recipes->onFirstPage())<span class="page-btn" style="opacity:.4"><i class="fas fa-chevron-left"></i></span>@else<a href="{{ $recipes->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>@endif
            @foreach($recipes->getUrlRange(max(1,$recipes->currentPage()-2), min($recipes->lastPage(),$recipes->currentPage()+2)) as $page=>$url)
                <a href="{{ $url }}" class="page-btn {{ $page==$recipes->currentPage()?'active':'' }}">{{ $page }}</a>
            @endforeach
            @if($recipes->hasMorePages())<a href="{{ $recipes->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>@else<span class="page-btn" style="opacity:.4"><i class="fas fa-chevron-right"></i></span>@endif
        </div>
    </div>
</div>
@endsection
