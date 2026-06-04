@extends('layouts.admin')
@section('title', 'Komentar & Rating')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:26px">
    <div>
        <h1 style="font-size:28px;font-weight:700;color:#111">Moderation Queue</h1>
        <p style="color:var(--text-m);margin-top:4px">Approve or flag community recipe reviews.</p>
    </div>
    <div style="display:flex;gap:12px">
        <div style="background:#FFF9EF;padding:10px 20px;border-radius:12px;font-size:13px;font-weight:700;">
            Pending: <span style="color:var(--primary);">{{ $stats['pending'] }}</span>
        </div>
        <div style="background:#E8F5E9;padding:10px 20px;border-radius:12px;font-size:13px;font-weight:700;color:#2E7D32;">
            Approved: {{ $stats['approved'] }}
        </div>
    </div>
</div>

<div class="white-card">
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="width:250px;">Recipe</th>
                <th style="width:150px;">Reviewer</th>
                <th>Comment</th>
                <th style="width:120px;">Rating</th>
                <th style="width:120px;">Status</th>
                <th style="width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $c)
            <tr>
                <td>
                    <div class="td-img">
                        <img src="https://placehold.co/100x100/FFF0EC/FF5A36?text={{ urlencode(Str::limit($c->recipe->title ?? 'Food', 10)) }}" alt="">
                        <div>
                            <h4>{{ Str::limit($c->recipe->title ?? 'Resep', 30) }}</h4>
                            <p>{{ $c->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="td-chef">
                        <img src="{{ $c->user->avatar_url }}" alt="">
                        {{ Str::slug($c->user->name ?? 'user', '') }}
                    </div>
                </td>
                <td style="font-size:13px;color:#555;line-height:1.4;">"{{ $c->comment }}"</td>
                <td style="color:#F59E0B;font-weight:700;">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= $c->rating ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </td>
                <td>
                    @if($c->is_approved)
                        <span class="badge badge-active">Approved</span>
                    @else
                        <span class="badge badge-pending">Pending Review</span>
                    @endif
                </td>
                <td>
                    <div class="td-acts">
                        @if(!$c->is_approved)
                        <form method="POST" action="{{ route('admin.moderation.approve', $c) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button class="tact tact-ok" title="Approve"><i class="fas fa-check"></i></button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.moderation.destroy', $c) }}" style="display:inline;" onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf @method('DELETE')
                            <button class="tact tact-del" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-m)">Antrean moderasi kosong!</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px;">
        {{ $comments->links() }}
    </div>
</div>
@endsection
