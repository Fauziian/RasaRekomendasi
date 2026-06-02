@extends('layouts.admin')
@section('title', 'Moderation')
@section('content')
<!-- Header Area matching Figma -->
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:26px">
    <div>
        <h1 style="font-size:32px;font-weight:800;color:#111;margin:0;">Moderation</h1>
        <p style="color:var(--text-m);margin-top:4px">Review and moderate community feedback</p>
    </div>
    <div style="display:flex;gap:12px;">
        <button class="btn btn-white" style="border-radius:10px;padding:10px 16px;font-size:13px;color:#333;font-weight:700;"><i class="fas fa-sliders-h"></i> Filters</button>
        <button class="btn btn-primary" style="background:#FF5A36;border:none;border-radius:10px;padding:10px 20px;font-size:13px;font-weight:700;"><i class="fas fa-check"></i> Approve All</button>
    </div>
</div>

<!-- Three Summary Cards matching Figma -->
<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;margin-bottom:28px">
    <!-- Card 1: Pending Review -->
    <div class="white-card" style="padding:22px;border-radius:16px;display:flex;align-items:center;gap:16px;">
        <div style="width:48px;height:48px;background:#FFF0EC;color:#FF5A36;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;">
            <i class="far fa-clipboard"></i>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Pending Review</div>
            <div style="font-size:28px;font-weight:800;color:#111;margin-top:2px;">{{ $stats['pending'] }}</div>
        </div>
    </div>

    <!-- Card 2: Approved Today -->
    <div class="white-card" style="padding:22px;border-radius:16px;display:flex;align-items:center;gap:16px;">
        <div style="width:48px;height:48px;background:#E8F5E9;color:#2E7D32;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;">
            <i class="far fa-check-circle"></i>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Approved Today</div>
            <div style="font-size:28px;font-weight:800;color:#111;margin-top:2px;">{{ $stats['approved'] }}</div>
        </div>
    </div>

    <!-- Card 3: Flagged -->
    <div class="white-card" style="padding:22px;border-radius:16px;display:flex;align-items:center;gap:16px;">
        <div style="width:48px;height:48px;background:#FFEBEE;color:#C62828;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Flagged</div>
            <div style="font-size:28px;font-weight:800;color:#111;margin-top:2px;">3</div>
        </div>
    </div>
</div>

<!-- Moderation Table Container -->
<div class="white-card" style="border-radius:16px;padding:26px;">
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="width:180px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">User</th>
                <th style="width:200px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Recipe</th>
                <th style="font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Comment Text</th>
                <th style="width:110px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Rating</th>
                <th style="width:120px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;">Status</th>
                <th style="width:110px;font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.8px;padding-bottom:12px;text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $c)
            <tr>
                <td style="padding:14px 0;vertical-align:middle;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <img src="{{ $c->user->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="">
                        <div>
                            <h4 style="font-size:13.5px;font-weight:700;color:#111;margin:0;">{{ $c->user->name }}</h4>
                            <p style="font-size:11px;color:#aaa;margin-top:2px;">{{ $c->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </td>
                <td style="padding:14px 0;vertical-align:middle;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <img src="https://placehold.co/100x100/FFF0EC/FF5A36?text={{ urlencode(Str::limit($c->recipe->title ?? 'Food', 10)) }}" style="width:28px;height:28px;border-radius:6px;object-fit:cover;" alt="">
                        <span style="font-size:13px;font-weight:700;color:#555;">{{ Str::limit($c->recipe->title ?? 'Resep', 22) }}</span>
                    </div>
                </td>
                <td style="padding:14px 0;vertical-align:middle;font-size:13px;color:#555;line-height:1.5;padding-right:15px;">
                    {{ $c->comment }}
                </td>
                <td style="padding:14px 0;vertical-align:middle;font-size:13px;font-weight:700;color:#FF9800;">
                    ★ {{ number_format($c->rating, 1) }}
                </td>
                <td style="padding:14px 0;vertical-align:middle;">
                    @if($c->is_approved)
                        <span class="badge" style="background:#ECEFF1;color:#546E7A;font-size:10px;font-weight:800;padding:4px 10px;border-radius:20px;">REVIEWED</span>
                    @else
                        <span class="badge" style="background:#FFF9EF;color:#FF9800;font-size:10px;font-weight:800;padding:4px 10px;border-radius:20px;">PENDING</span>
                    @endif
                </td>
                <td style="padding:14px 0;vertical-align:middle;text-align:center;">
                    <div style="display:inline-flex;gap:8px;align-items:center;">
                        @if($c->is_approved)
                            <span style="color:#2E7D32;font-size:13px;font-weight:bold;margin-right:6px;"><i class="fas fa-check"></i></span>
                            <span style="color:#E53935;font-size:13px;opacity:0.3;"><i class="fas fa-times"></i></span>
                        @else
                            <form method="POST" action="{{ route('admin.moderation.approve', $c) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button style="border:none;background:#2E7D32;color:#FFF;width:28px;height:28px;border-radius:50%;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:11px;transition:transform 0.1s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.moderation.destroy', $c) }}" style="display:inline;" onsubmit="return confirm('Hapus komentar ini?')">
                                @csrf @method('DELETE')
                                <button style="border:none;background:#E53935;color:#FFF;width:28px;height:28px;border-radius:50%;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:11px;transition:transform 0.1s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Reject/Delete">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:40px;color:var(--text-m)">Antrean moderasi kosong!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top:20px;">
        {{ $comments->links() }}
    </div>
</div>
@endsection
