@extends('layouts.chef')
@section('title', 'Chef Dashboard')

@section('content')
<!-- Header Row -->
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:28px">
    <div>
        <h1 style="font-size:32px;font-weight:800;color:#111;font-family:'Outfit',sans-serif">Selamat Pagi, Chef!</h1>
        <p style="color:var(--text-m);margin-top:4px">Here is what's happening today.</p>
    </div>
</div>

<!-- 4 Metrics Stats Cards -->
<div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:20px;margin-bottom:28px">
    <!-- Card 1: JADWAL TERSEDIA -->
    <div class="white-card" style="margin-bottom:0;padding:24px;border-top:3px solid #A03010;position:relative;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
            <div style="width:40px;height:40px;background:#FFF0EC;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#A03010;font-size:18px;">
                <i class="far fa-calendar-alt"></i>
            </div>
            <span style="font-size:9px;font-weight:800;background:#FFF0EC;color:#A03010;padding:2px 8px;border-radius:10px;">+2 Today</span>
        </div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Jadwal Tersedia</div>
        <div style="font-size:30px;font-weight:800;color:#111;margin-top:4px;">14 Slot</div>
    </div>

    <!-- Card 2: TOTAL BOOKING -->
    <div class="white-card" style="margin-bottom:0;padding:24px;border-top:3px solid #2E7D32;position:relative;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
            <div style="width:40px;height:40px;background:#E8F5E9;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#2E7D32;font-size:18px;">
                <i class="fas fa-users"></i>
            </div>
            <span style="font-size:9px;font-weight:800;background:#E8F5E9;color:#2E7D32;padding:2px 8px;border-radius:10px;">New</span>
        </div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Total Booking</div>
        <div style="font-size:30px;font-weight:800;color:#111;margin-top:4px;">86 User</div>
    </div>

    <!-- Card 3: SESI HARI INI -->
    <div class="white-card" style="margin-bottom:0;padding:24px;border-top:3px solid #FF9800;position:relative;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
            <div style="width:40px;height:40px;background:#FFF9EF;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#FF9800;font-size:18px;">
                <i class="far fa-clock"></i>
            </div>
        </div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Sesi Hari Ini</div>
        <div style="font-size:30px;font-weight:800;color:#111;margin-top:4px;">5 Sesi</div>
    </div>

    <!-- Card 4: CHAT AKTIF -->
    <div class="white-card" style="margin-bottom:0;padding:24px;border-top:3px solid #555;position:relative;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
            <div style="width:40px;height:40px;background:#F5F5F5;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#555;font-size:18px;">
                <i class="fas fa-comments"></i>
            </div>
        </div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:0.8px;">Chat Aktif</div>
        <div style="font-size:30px;font-weight:800;color:#111;margin-top:4px;">{{ $stats['active_chats'] }} Pesan</div>
    </div>
</div>

<!-- Two Column Layout -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">
    <!-- Left Column: Consultations & Call-to-action Banner -->
    <div>
        <!-- Jadwal Konsultasi Terdekat -->
        <div class="white-card" style="border-radius:16px;padding:26px;margin-bottom:24px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
                <h3 style="font-size:19px;font-weight:800;color:#111">Jadwal Konsultasi Terdekat</h3>
                <a href="{{ route('chef.schedules.index') }}" style="color:#A03010;font-size:13px;font-weight:700;display:flex;align-items:center;gap:4px;">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>

            <div style="display:flex;flex-direction:column;gap:16px;">
                <!-- Booking Item 1 -->
                <div style="background:#FFF8F6;border:1px solid #FFE0D8;border-radius:14px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:16px;">
                        <div style="width:50px;height:50px;background:#FFF;border-radius:10px;border:1px solid #FFE0D8;display:flex;flex-direction:column;align-items:center;justify-content:center;line-height:1.2;">
                            <span style="font-size:16px;font-weight:800;color:#A03010;">10</span>
                            <span style="font-size:9px;font-weight:700;color:#aaa;text-transform:uppercase;">Okt</span>
                        </div>
                        <div>
                            <h4 style="font-size:15px;font-weight:800;color:#111;margin:0;">Konsultasi Diet Keto Modern</h4>
                            <p style="font-size:12px;color:var(--text-m);margin-top:4px;">User: Budi Santoso • 14:00 - 14:45</p>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <button style="border:none;background:#EEE;color:#666;width:34px;height:34px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;"><i class="fas fa-pencil-alt"></i></button>
                        <a href="{{ route('chef.consultations.index') }}" class="btn btn-primary" style="background:#A03010;border:none;font-size:12px;padding:8px 18px;border-radius:20px;">Mulai Chat</a>
                    </div>
                </div>

                <!-- Booking Item 2 -->
                <div style="background:#FFF;border:1px solid #F0F0F0;border-radius:14px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:16px;">
                        <div style="width:50px;height:50px;background:#F8F9FA;border-radius:10px;border:1px solid #EEE;display:flex;flex-direction:column;align-items:center;justify-content:center;line-height:1.2;">
                            <span style="font-size:16px;font-weight:800;color:#555;">10</span>
                            <span style="font-size:9px;font-weight:700;color:#aaa;text-transform:uppercase;">Okt</span>
                        </div>
                        <div>
                            <h4 style="font-size:15px;font-weight:800;color:#111;margin:0;">Resep MPASI Sehat</h4>
                            <p style="font-size:12px;color:var(--text-m);margin-top:4px;">User: Siti Aminah • 16:30 - 17:15</p>
                        </div>
                    </div>
                    <span style="background:#F5F5F5;color:#777;font-size:11px;font-weight:700;padding:6px 14px;border-radius:20px;">Menunggu</span>
                </div>

                <!-- Booking Item 3 -->
                <div style="background:#FFF;border:1px solid #F0F0F0;border-radius:14px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:16px;">
                        <div style="width:50px;height:50px;background:#F8F9FA;border-radius:10px;border:1px solid #EEE;display:flex;flex-direction:column;align-items:center;justify-content:center;line-height:1.2;">
                            <span style="font-size:16px;font-weight:800;color:#555;">11</span>
                            <span style="font-size:9px;font-weight:700;color:#aaa;text-transform:uppercase;">Okt</span>
                        </div>
                        <div>
                            <h4 style="font-size:15px;font-weight:800;color:#111;margin:0;">Food Photography & Styling</h4>
                            <p style="font-size:12px;color:var(--text-m);margin-top:4px;">User: David Chandra • 09:00 - 10:00</p>
                        </div>
                    </div>
                    <span style="background:#E8F5E9;color:#2E7D32;font-size:11px;font-weight:700;padding:6px 14px;border-radius:20px;">Terjadwal</span>
                </div>
            </div>
        </div>

        <!-- Orange CTA Banner Card -->
        <div style="background:#FFC1B2;border-radius:20px;padding:28px 36px;display:flex;justify-content:space-between;align-items:center;position:relative;overflow:hidden;box-shadow:0 8px 24px rgba(255,90,54,0.15);min-height:175px;">
            <div style="max-width:300px;z-index:2;">
                <h3 style="font-size:22px;font-weight:800;color:#A03010;line-height:1.3;margin-bottom:8px;">Butuh Respon Cepat?</h3>
                <p style="font-size:12px;color:#A03010;font-weight:600;line-height:1.5;margin-bottom:18px;">Ada 3 pesan belum terbaca dari VIP kitchen users yang menunggu saran bumbu Anda.</p>
                <a href="{{ route('chef.consultations.index') }}" class="btn btn-primary" style="background:#A03010;color:#FFF;border-radius:24px;font-size:12px;padding:10px 24px;">Buka Chat Center <i class="fas fa-chevron-right" style="font-size:10px;margin-left:4px;"></i></a>
            </div>
            
            <!-- Styled visual placeholder matching the Figma mockup -->
            <div style="position:absolute;right:20px;bottom:-20px;width:240px;height:210px;z-index:1;background:url('https://placehold.co/240x210/FFF0EC/FF5A36?text=Bumbu+Kuning') no-repeat center;background-size:cover;border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,0.12);border:3px solid #FFF;">
            </div>
        </div>
    </div>

    <!-- Right Column: VIP Bookings & Notes -->
    <div>
        <!-- VIP Booking Panel -->
        <div class="white-card" style="border-radius:16px;padding:26px;margin-bottom:24px;">
            <h3 style="font-size:16px;font-weight:800;color:#111;margin-bottom:20px;">VIP Booking</h3>
            
            <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:20px;">
                <!-- VIP User 1 -->
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <img src="https://i.pravatar.cc/80?img=47" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:1px solid #EEE;" alt="">
                        <div>
                            <h4 style="font-size:13px;font-weight:800;color:#333;margin:0;">Maya Wijaya</h4>
                            <p style="font-size:10px;font-weight:700;color:#2E7D32;margin-top:2px;">Platinum Member</p>
                        </div>
                    </div>
                    <a href="{{ route('chef.consultations.index') }}" style="color:#A03010;font-size:16px;"><i class="far fa-comment-dots"></i></a>
                </div>

                <!-- VIP User 2 -->
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <img src="https://i.pravatar.cc/80?img=12" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:1px solid #EEE;" alt="">
                        <div>
                            <h4 style="font-size:13px;font-weight:800;color:#333;margin:0;">Andika Pratama</h4>
                            <p style="font-size:10px;font-weight:700;color:#FF9800;margin-top:2px;">Gold Member</p>
                        </div>
                    </div>
                    <a href="{{ route('chef.consultations.index') }}" style="color:#A03010;font-size:16px;"><i class="far fa-comment-dots"></i></a>
                </div>
            </div>

            <button onclick="window.location='{{ route('chef.consultations.index') }}'" style="width:100%;height:38px;border:1px solid #A03010;background:transparent;color:#A03010;border-radius:10px;font-family:inherit;font-weight:700;font-size:12px;cursor:pointer;">Manage VIP List</button>
        </div>

        <!-- Daily Chef Notes -->
        <div class="white-card" style="border-radius:16px;padding:26px;background:#FFFDF0;border:1px solid #FDEBB7;">
            <h3 style="font-size:16px;font-weight:800;color:#8B6508;margin-bottom:16px;">Daily Chef Notes</h3>
            <ul style="list-style:none;display:flex;flex-direction:column;gap:12px;font-size:12px;color:#7c5b00;font-weight:600;line-height:1.5;">
                <li style="display:flex;gap:6px;align-items:flex-start;">
                    <span style="font-size:10px;margin-top:2px;">●</span>
                    Ingatkan user untuk tentang alergi kacang pada resep Rendang.
                </li>
                <li style="display:flex;gap:6px;align-items:flex-start;">
                    <span style="font-size:10px;margin-top:2px;">●</span>
                    Siapkan materi konsultasi "Bumbu Dasar Kuning" jam 1 siang.
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
