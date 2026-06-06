@extends('layouts.app')
@section('title', 'Sesi VIP Chat - Chef ' . $consultation->chef->name)
@section('content')
<div class="page-padding" style="max-width:800px;margin:0 auto;padding-top:20px;padding-bottom:60px;">
    <div style="margin-bottom:20px;display:flex;align-items:center;gap:12px;">
        <a href="{{ route('consultations.index') }}" class="btn btn-white btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#111;margin:0;">VIP Consultation Chat</h1>
            <p style="color:var(--text-m);font-size:12px;margin:0;">Konsultasi Privat Kuliner Bersama <strong>{{ $consultation->chef->formatted_name }}</strong></p>
        </div>
    </div>

    <div class="card" style="height:60vh;display:flex;flex-direction:column;padding:0;overflow:hidden;border:none;box-shadow:var(--shadow-lg);">
        {{-- Chat Header --}}
        <div style="padding:15px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;background:#fff;">
            <img src="{{ $consultation->chef->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="">
            <div>
                <div style="font-size:13px;font-weight:700;">{{ $consultation->chef->formatted_name }}</div>
                <div style="font-size:11px;color:#2E7D32;"><i class="fas fa-circle" style="font-size:8px;"></i> Certified Professional Chef</div>
            </div>
        </div>

        {{-- Chat Messages Body --}}
        <div style="flex:1;padding:20px;overflow-y:auto;background:#FDFCF8;display:flex;flex-direction:column;gap:12px;" id="chatBody">
            @forelse($messages as $msg)
                @php $isMe = $msg->sender_id === Auth::id(); @endphp
                <div style="display:flex;justify-content:{{ $isMe ? 'flex-end' : 'flex-start' }};">
                    <div style="max-width:70%;padding:10px 14px;border-radius:12px;background:{{ $isMe ? 'var(--primary)' : '#F0F0F0' }};color:{{ $isMe ? '#fff' : '#111' }};font-size:13px;line-height:1.4;">
                        {{ $msg->body }}
                        <div style="font-size:9px;text-align:right;opacity:0.8;margin-top:4px;">{{ $msg->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @empty
                <div style="text-align:center;color:var(--text-m);padding:40px;font-size:13px;">Belum ada percakapan. Mulai bimbingan kuliner Anda dengan menulis pesan pertama!</div>
            @endforelse
        </div>

        {{-- Chat Form Send --}}
        <div style="padding:15px;border-top:1px solid var(--border);background:#fff;">
            <form method="POST" action="{{ route('consultations.message', $consultation) }}" style="display:flex;gap:10px;">
                @csrf
                <input type="text" name="message" placeholder="Tanyakan resep, teknik memasak, atau pengganti bahan..." class="form-control" style="flex:1;margin:0;" required autocomplete="off">
                <button type="submit" class="btn"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Keep chat scrolled to bottom
    const chatBody = document.getElementById('chatBody');
    chatBody.scrollTop = chatBody.scrollHeight;
</script>
@endpush
@endsection
