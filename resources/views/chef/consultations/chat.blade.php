@extends('layouts.chef')
@section('title', 'VIP Chat dengan ' . $consultation->user->name)

@section('content')
<!-- Back button & Header Info -->
<div style="margin-bottom:20px;display:flex;align-items:center;gap:12px;">
    <a href="{{ route('chef.consultations.index') }}" class="btn btn-white btn-sm" style="border-radius:10px;padding:6px 12px;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <div>
        <h1 style="font-size:24px;font-weight:800;color:#111;font-family:'Outfit',sans-serif;margin:0;">Consultation with Chef</h1>
        <p style="color:#2E7D32;font-size:12px;font-weight:700;margin:2px 0 0 0;display:flex;align-items:center;gap:6px;">
            <span style="display:inline-block;width:8px;height:8px;background:#2E7D32;border-radius:50%;animation:pulse 1.5s infinite;"></span> Live Session Active
        </p>
    </div>
</div>

<!-- 2-Column Chat Layout -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;min-height:75vh;">
    <!-- Left Chat Area -->
    <div class="white-card" style="border-radius:20px;padding:0;display:flex;flex-direction:column;overflow:hidden;border:1px solid #F0F0F0;box-shadow:0 8px 30px rgba(0,0,0,0.03);">
        <!-- Scrollable Messages Body -->
        <div style="flex:1;padding:24px;overflow-y:auto;background:#FAF8F5;display:flex;flex-direction:column;gap:18px;" id="chatBody">
            <div style="text-align:center;margin:10px 0;"><span style="background:#FFF;color:#777;font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;border:1px solid #EEE;text-transform:uppercase;">Today, 24 Oct</span></div>

            <!-- Chef First Message -->
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <img src="{{ Auth::user()->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:1px solid #EEE;" alt="">
                <div>
                    <div style="background:#FFF;padding:12px 16px;border-radius:0 16px 16px 16px;box-shadow:0 2px 8px rgba(0,0,0,0.02);font-size:13.5px;color:#111;max-width:380px;line-height:1.4;">
                        Selamat siang, Budi! I'm ready to help you perfect your Rendang today. Do you have all the spices laid out?
                    </div>
                    <div style="font-size:10px;color:#999;margin-top:4px;margin-left:4px;">14:02 PM</div>
                </div>
            </div>

            <!-- User Response -->
            <div style="display:flex;align-items:flex-start;gap:12px;justify-content:flex-end;">
                <div style="text-align:right;">
                    <div style="background:#A03010;color:#FFF;padding:12px 16px;border-radius:16px 0 16px 16px;box-shadow:0 2px 8px rgba(160,48,16,0.15);font-size:13.5px;max-width:380px;line-height:1.4;text-align:left;">
                        Siang, Chef! Yes, I have the galangal, lemongrass, and the fresh coconut milk ready. But my chili paste looks a bit darker than yours.
                    </div>
                    <div style="font-size:10px;color:#999;margin-top:4px;margin-right:4px;">14:05 PM <i class="fas fa-check-double" style="color:#A03010;"></i></div>
                </div>
                <div style="width:36px;height:36px;border-radius:50%;background:#FFF0EC;color:#A03010;font-weight:800;display:flex;align-items:center;justify-content:center;font-size:13px;border:1px solid #FFE0D8;">BK</div>
            </div>

            <!-- Chef Visual Answer with Image -->
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <img src="{{ Auth::user()->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:1px solid #EEE;" alt="">
                <div>
                    <div style="background:#FFF;border-radius:0 16px 16px 16px;box-shadow:0 2px 8px rgba(0,0,0,0.02);overflow:hidden;max-width:380px;border:1px solid #EEE;">
                        <img src="https://placehold.co/400x300/A03010/FFF?text=Spicy+Rendang+Paste" style="width:100%;height:180px;object-fit:cover;" alt="Chili Paste">
                        <div style="padding:12px 16px;font-size:13.5px;color:#111;line-height:1.4;">
                            It should look like this. The darkness might be from the type of dried chilies you used. Don't worry, the flavor will still be intense!
                        </div>
                    </div>
                    <div style="font-size:10px;color:#999;margin-top:4px;margin-left:4px;">14:06 PM</div>
                </div>
            </div>

            <!-- User Response 2 -->
            <div style="display:flex;align-items:flex-start;gap:12px;justify-content:flex-end;">
                <div style="text-align:right;">
                    <div style="background:#A03010;color:#FFF;padding:12px 16px;border-radius:16px 0 16px 16px;box-shadow:0 2px 8px rgba(160,48,16,0.15);font-size:13.5px;max-width:380px;line-height:1.4;text-align:left;">
                        Got it! Should I start searing the beef now?
                    </div>
                    <div style="font-size:10px;color:#999;margin-top:4px;margin-right:4px;">14:08 PM <i class="fas fa-check-double" style="color:#A03010;"></i></div>
                </div>
                <div style="width:36px;height:36px;border-radius:50%;background:#FFF0EC;color:#A03010;font-weight:800;display:flex;align-items:center;justify-content:center;font-size:13px;border:1px solid #FFE0D8;">BK</div>
            </div>

            <!-- Render Real Messages from database on top of mock conversation -->
            @foreach($messages as $msg)
                @php $isMe = $msg->sender_id === Auth::id(); @endphp
                @if($isMe)
                    <div style="display:flex;align-items:flex-start;gap:12px;justify-content:flex-end;">
                        <div style="text-align:right;">
                            <div style="background:#A03010;color:#FFF;padding:12px 16px;border-radius:16px 0 16px 16px;box-shadow:0 2px 8px rgba(160,48,16,0.15);font-size:13.5px;max-width:380px;line-height:1.4;text-align:left;">
                                {{ $msg->message }}
                            </div>
                            <div style="font-size:10px;color:#999;margin-top:4px;margin-right:4px;">{{ $msg->created_at->format('H:i A') }} <i class="fas fa-check-double" style="color:#A03010;"></i></div>
                        </div>
                        <div style="width:36px;height:36px;border-radius:50%;background:#FFF0EC;color:#A03010;font-weight:800;display:flex;align-items:center;justify-content:center;font-size:13px;border:1px solid #FFE0D8;">BK</div>
                    </div>
                @else
                    <div style="display:flex;align-items:flex-start;gap:12px;">
                        <img src="{{ Auth::user()->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:1px solid #EEE;" alt="">
                        <div>
                            <div style="background:#FFF;padding:12px 16px;border-radius:0 16px 16px 16px;box-shadow:0 2px 8px rgba(0,0,0,0.02);font-size:13.5px;color:#111;max-width:380px;line-height:1.4;">
                                {{ $msg->message }}
                            </div>
                            <div style="font-size:10px;color:#999;margin-top:4px;margin-left:4px;">{{ $msg->created_at->format('H:i A') }}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Chat Form Input Panel -->
        <div style="padding:20px;border-top:1px solid #F0F0F0;background:#FFF;">
            <form method="POST" action="{{ route('chef.consultations.message', $consultation) }}" style="display:flex;align-items:center;gap:14px;">
                @csrf
                <button type="button" style="border:none;background:#F5F5F5;color:#666;width:40px;height:40px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;">
                    <i class="fas fa-plus"></i>
                </button>
                <input type="text" name="message" placeholder="Type your message..." style="flex:1;height:44px;border-radius:22px;border:1px solid #EEE;background:#F8F9FA;padding:0 20px;font-family:inherit;font-size:13.5px;outline:none;" required autocomplete="off">
                <button type="button" style="border:none;background:transparent;color:#777;font-size:18px;cursor:pointer;">
                    <i class="far fa-smile"></i>
                </button>
                <button type="submit" style="border:none;background:#A03010;color:#FFF;width:40px;height:40px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;box-shadow:0 4px 10px rgba(160,48,16,0.25);">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Right Session Details Panel -->
    <div>
        <!-- Card 1: Session Details -->
        <div class="white-card" style="border-radius:16px;padding:24px;margin-bottom:20px;border:1px solid #F0F0F0;">
            <h3 style="font-size:15px;font-weight:800;color:#111;margin-bottom:18px;">Session Details</h3>
            
            <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:20px;">
                <!-- Date -->
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:34px;height:34px;border-radius:8px;background:#FFF0EC;color:#A03010;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div style="font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;">Date</div>
                        <div style="font-size:13px;font-weight:700;color:#333;">Thursday, 24 October 2024</div>
                    </div>
                </div>

                <!-- Time -->
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:34px;height:34px;border-radius:8px;background:#FFF9EF;color:#FF9800;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="far fa-clock"></i>
                    </div>
                    <div>
                        <div style="font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;">Time</div>
                        <div style="font-size:13px;font-weight:700;color:#333;">14:00 - 15:00 (60 Mins)</div>
                    </div>
                </div>

                <!-- Class Type -->
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:34px;height:34px;border-radius:8px;background:#E8F5E9;color:#2E7D32;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div>
                        <div style="font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:0.5px;">Class Type</div>
                        <div style="font-size:13px;font-weight:700;color:#333;">VIP Private Consultation</div>
                    </div>
                </div>
            </div>

            <!-- Session Status Progress Bar -->
            <div style="border-top:1px solid #F8F9FA;padding-top:16px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;font-size:11px;font-weight:700;">
                    <span style="color:#aaa;">STATUS</span>
                    <span style="color:#2E7D32;background:#E8F5E9;padding:2px 8px;border-radius:10px;">IN PROGRESS</span>
                </div>
                <div style="width:100%;height:6px;background:#EEE;border-radius:3px;overflow:hidden;">
                    <div style="width:15%;height:100%;background:#2E7D32;border-radius:3px;animation:growWidth 2s ease-out;"></div>
                </div>
                <div style="font-size:11px;color:#777;margin-top:6px;">9 minutes elapsed</div>
            </div>
        </div>

        <!-- Card 2: Handy Tools -->
        <div class="white-card" style="border-radius:16px;padding:24px;margin-bottom:20px;border:1px solid #F0F0F0;">
            <h3 style="font-size:15px;font-weight:800;color:#111;margin-bottom:18px;">Handy Tools</h3>
            
            <div style="display:flex;flex-direction:column;gap:12px;">
                <!-- Join Video Call Button -->
                <button onclick="alert('Launching visual video conference stream...')" style="width:100%;padding:14px;background:#FFF;border:1px solid #FFE0D8;border-radius:12px;cursor:pointer;display:flex;align-items:center;gap:12px;text-align:left;transition:all 0.2s;" onmouseover="this.style.background='#FFF8F6'" onmouseout="this.style.background='#FFF'">
                    <div style="width:34px;height:34px;border-radius:50%;background:#FFF0EC;color:#FF5A36;display:flex;align-items:center;justify-content:center;font-size:14px;"><i class="fas fa-video"></i></div>
                    <div>
                        <div style="font-size:13px;font-weight:800;color:#111;">Join Video Call</div>
                        <div style="font-size:10px;color:#aaa;">Switch to face-to-face</div>
                    </div>
                </button>

                <!-- Shared Recipe Button -->
                <button onclick="alert('Viewing Shared Recipe details...')" style="width:100%;padding:14px;background:#FFF;border:1px solid #FFE0D8;border-radius:12px;cursor:pointer;display:flex;align-items:center;gap:12px;text-align:left;transition:all 0.2s;" onmouseover="this.style.background='#FFF8F6'" onmouseout="this.style.background='#FFF'">
                    <div style="width:34px;height:34px;border-radius:50%;background:#FFF0EC;color:#FF5A36;display:flex;align-items:center;justify-content:center;font-size:14px;"><i class="fas fa-book-open"></i></div>
                    <div>
                        <div style="font-size:13px;font-weight:800;color:#111;">View Shared Recipe</div>
                        <div style="font-size:10px;color:#aaa;">Authentic Beef Rendong</div>
                    </div>
                </button>
            </div>
        </div>

        <!-- End Session Outlined Red Button -->
        <button onclick="alert('Sesi konsultasi ditutup.')" style="width:100%;height:44px;border:1px solid #C62828;background:transparent;color:#C62828;border-radius:12px;font-family:inherit;font-weight:700;font-size:13px;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='#FFEBEE'" onmouseout="this.style.background='transparent'">
            End Session Early
        </button>
    </div>
</div>

@push('styles')
<style>
    @keyframes pulse {
        0% { transform: scale(0.9); opacity: 0.7; }
        50% { transform: scale(1.15); opacity: 1; }
        100% { transform: scale(0.9); opacity: 0.7; }
    }
</style>
@endpush

@push('scripts')
<script>
    const chatBody = document.getElementById('chatBody');
    chatBody.scrollTop = chatBody.scrollHeight;
</script>
@endpush
@endsection
