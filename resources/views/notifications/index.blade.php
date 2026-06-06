@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'chef' ? 'layouts.chef' : 'layouts.app'))

@section('title', 'Notifikasi Saya')

@section('content')
<div class="page-padding" style="padding-top: 30px; padding-bottom: 60px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div>
                <h1 style="font-size:28px; font-weight:800; color:#111;">Pusat Notifikasi</h1>
                <p style="color:#777; font-size:14px; margin-top:2px;">Pantau pembaruan aktivitas dan interaksi akun Anda.</p>
            </div>
            
            @if(Auth::user()->notifications()->where('is_read', false)->exists())
                <form method="POST" action="{{ route('notifications.read_all') }}">
                    @csrf
                    <button type="submit" class="btn btn-white btn-sm" style="font-weight:700;">
                        <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div style="text-align:center; padding:80px 20px; background:#FFF; border: 1px solid #EAE6DF; border-radius:20px;">
                <div style="width:70px; height:70px; border-radius:50%; background:#F5F5F5; color:#AAA; display:flex; align-items:center; justify-content:center; font-size:28px; margin: 0 auto 20px;">
                    <i class="far fa-bell-slash"></i>
                </div>
                <h3 style="font-size:18px; font-weight:800; color:#111; margin-bottom:6px;">Tidak Ada Notifikasi</h3>
                <p style="color:#777; font-size:13px;">Semua sunyi di sini. Kami akan memberi tahu jika ada hal baru untuk Anda!</p>
            </div>
        @else
            <div style="background:#FFF; border: 1px solid #EAE6DF; border-radius:20px; overflow:hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.01);">
                @foreach($notifications as $notif)
                    @php
                        $isPendingComment = Auth::user()->role === 'admin' 
                            && $notif->comment_rating_id 
                            && $notif->commentRating 
                            && !$notif->commentRating->is_approved;
                    @endphp

                    @if($isPendingComment)
                        <div style="text-decoration:none; color:inherit; display:block;">
                    @else
                        <a href="{{ route('notifications.read', $notif->id) }}" style="text-decoration:none; color:inherit; display:block;">
                    @endif
                        <div style="padding:20px 24px; border-bottom:1px solid #F0F0F0; display:flex; gap:16px; align-items:flex-start; transition: background 0.2s; {{ !$notif->is_read ? 'background:#FFF8F5;' : '' }}" class="notif-item">
                            
                            {{-- Icon --}}
                            <div style="width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; 
                                @if(str_contains(strtolower($notif->title), 'pesan'))
                                    background:#E1F5FE; color:#0288D1;
                                @elseif(str_contains(strtolower($notif->title), 'favorit'))
                                    background:#FFF0EC; color:#FF5A36;
                                @elseif(str_contains(strtolower($notif->title), 'ulasan') || str_contains(strtolower($notif->title), 'comment'))
                                    background:#FFF4E0; color:#FF9800;
                                @elseif(str_contains(strtolower($notif->title), 'pembayaran') || str_contains(strtolower($notif->title), 'disetujui'))
                                    background:#E8F5E9; color:#2E7D32;
                                @else
                                    background:#F5F5F5; color:#666;
                                @endif
                            ">
                                @if(str_contains(strtolower($notif->title), 'pesan'))
                                    <i class="far fa-comment-dots"></i>
                                @elseif(str_contains(strtolower($notif->title), 'favorit'))
                                    <i class="far fa-heart"></i>
                                @elseif(str_contains(strtolower($notif->title), 'ulasan') || str_contains(strtolower($notif->title), 'comment'))
                                    <i class="far fa-star"></i>
                                @elseif(str_contains(strtolower($notif->title), 'pembayaran') || str_contains(strtolower($notif->title), 'disetujui'))
                                    <i class="far fa-check-circle"></i>
                                @else
                                    <i class="far fa-bell"></i>
                                @endif
                            </div>

                            {{-- Text & Action Buttons --}}
                            <div style="flex:1; display:flex; justify-content:space-between; align-items:center; gap:20px;">
                                <div style="flex:1;">
                                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px;">
                                        <h4 style="font-size:15px; font-weight:800; color:#111; margin:0;">
                                            {{ $notif->title }}
                                            @if(!$notif->is_read)
                                                <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#FF5A36; margin-left:6px; vertical-align:middle;"></span>
                                            @endif
                                        </h4>
                                        <span style="font-size:11px; color:#AAA; white-space:nowrap; font-weight:600;">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p style="color:#555; font-size:13px; margin-top:4px; line-height:1.5; font-weight: 500;">
                                        {{ $notif->message }}
                                    </p>
                                </div>

                                @if($isPendingComment)
                                    <div style="display:inline-flex; gap:8px; align-items:center; flex-shrink:0;">
                                        <form method="POST" action="{{ route('admin.moderation.approve', $notif->comment_rating_id) }}" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button style="border:none;background:#2E7D32;color:#FFF;width:32px;height:32px;border-radius:50%;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:12px;transition:transform 0.1s;box-shadow:0 2px 6px rgba(46,125,50,0.2);" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.moderation.destroy', $notif->comment_rating_id) }}" style="display:inline;" onsubmit="return confirm('Hapus komentar ini?')">
                                            @csrf @method('DELETE')
                                            <button style="border:none;background:#E53935;color:#FFF;width:32px;height:32px;border-radius:50%;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:12px;transition:transform 0.1s;box-shadow:0 2px 6px rgba(229,57,53,0.2);" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @if($isPendingComment)
                        </div>
                    @else
                        </a>
                    @endif
                @endforeach
            </div>
            
            <div style="margin-top:20px;">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>
</div>

<style>
    .notif-item:hover {
        background: #FAFAFA !important;
    }
</style>
@endsection
