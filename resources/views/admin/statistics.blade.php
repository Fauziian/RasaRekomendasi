@extends('layouts.admin')
@section('title', 'Statistik')

@section('content')
<!-- Header Row -->
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:28px">
    <div>
        <h1 style="font-size:32px;font-weight:700;color:#111;font-family:'Outfit',sans-serif">Growth & Metrics</h1>
        <p style="color:var(--text-m);margin-top:4px">Insights and real-time data analysis of user interactions and recipe performance for RasaRekomendasi.</p>
    </div>
    <div style="display:flex;gap:12px">
        <button class="btn btn-white" style="font-size:13px;"><i class="far fa-calendar"></i> Last 30 Days</button>
        <button class="btn btn-primary" style="font-size:13px;background:#A03010;color:#fff;border:none;"><i class="fas fa-file-export"></i> Export Report</button>
    </div>
</div>

<!-- Grid: Growth & Preferences -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:28px">
    <!-- Growth Metrics Area Chart Card -->
    <div class="white-card" style="border-radius:16px;padding:26px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
            <h3 style="font-size:19px;font-weight:700;color:#111">Growth Metrics</h3>
            <div style="display:flex;gap:16px;font-size:12px;font-weight:700;">
                <span style="display:flex;align-items:center;gap:6px;color:#A03010">
                    <span style="width:8px;height:8px;background:#A03010;border-radius:50%;display:inline-block"></span> New Users
                </span>
                <span style="display:flex;align-items:center;gap:6px;color:#2E7D32">
                    <span style="width:8px;height:8px;background:#2E7D32;border-radius:50%;display:inline-block"></span> Active Sessions
                </span>
            </div>
        </div>

        <!-- SVG Filled Area Graph -->
        <div style="height:200px;width:100%;">
            <svg viewBox="0 0 500 160" preserveAspectRatio="none" style="width:100%;height:100%">
                <defs>
                    <linearGradient id="growthGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#A03010" stop-opacity="0.25"/>
                        <stop offset="100%" stop-color="#A03010" stop-opacity="0.01"/>
                    </linearGradient>
                </defs>
                <!-- Grid helper lines -->
                <line x1="0" y1="40" x2="500" y2="40" stroke="#F5F5F5" stroke-width="1"/>
                <line x1="0" y1="80" x2="500" y2="80" stroke="#F5F5F5" stroke-width="1"/>
                <line x1="0" y1="120" x2="500" y2="120" stroke="#F5F5F5" stroke-width="1"/>

                <!-- Area Path -->
                <path d="M 0 130 C 40 120, 60 90, 80 90 C 120 90, 140 110, 160 110 C 200 110, 220 50, 240 50 C 280 50, 300 120, 320 120 C 360 120, 380 30, 420 30 C 460 30, 480 80, 500 90 L 500 140 L 0 140 Z" fill="url(#growthGradient)"/>
                <!-- Line Path -->
                <path d="M 0 130 C 40 120, 60 90, 80 90 C 120 90, 140 110, 160 110 C 200 110, 220 50, 240 50 C 280 50, 300 120, 320 120 C 360 120, 380 30, 420 30 C 460 30, 480 80, 500 90" fill="none" stroke="#A03010" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:10px;color:#aaa;font-size:11px;font-weight:700;">
            <span>MON</span><span>TUE</span><span>WED</span><span>THU</span><span>FRI</span><span>SAT</span><span>SUN</span>
        </div>
    </div>

    <!-- Preferences Donut Card -->
    <div class="white-card" style="border-radius:16px;padding:26px;background:#FFFDF7;border:1px solid #FDF5E6;">
        <h3 style="font-size:19px;font-weight:700;color:#111;margin-bottom:20px">Preferences</h3>
        
        <!-- SVG Donut Chart -->
        <div style="position:relative;width:120px;height:120px;margin:0 auto 20px;">
            <svg viewBox="0 0 36 36" style="width:100%;height:100%">
                <!-- Gray background circle -->
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f1f1f1" stroke-width="3.5" />
                <!-- Savory Green progress -->
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#2E7D32" stroke-width="3.5"
                        stroke-dasharray="84 16" stroke-dashoffset="25" stroke-linecap="round"/>
            </svg>
            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                <div style="font-size:20px;font-weight:800;color:#111;line-height:1">84%</div>
                <div style="font-size:9px;font-weight:700;color:#aaa;margin-top:2px;letter-spacing:0.5px;">SAVORY</div>
            </div>
        </div>

        <!-- Preferences items list -->
        <div style="display:flex;flex-direction:column;gap:10px;">
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                <span style="display:flex;align-items:center;gap:8px;font-weight:600;color:#333">
                    <span style="width:8px;height:8px;background:#A03010;border-radius:50%"></span> Savory Lovers
                </span>
                <span style="font-weight:700;color:#111">842</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                <span style="display:flex;align-items:center;gap:8px;font-weight:600;color:#333">
                    <span style="width:8px;height:8px;background:#2E7D32;border-radius:50%"></span> Spicy Adventurers
                </span>
                <span style="font-weight:700;color:#111">415</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                <span style="display:flex;align-items:center;gap:8px;font-weight:600;color:#333">
                    <span style="width:8px;height:8px;background:#EAD2A8;border-radius:50%"></span> Sweet Tooths
                </span>
                <span style="font-weight:700;color:#111">120</span>
            </div>
        </div>
    </div>
</div>

<!-- Most Popular Recipes list with horizontal bars -->
<div class="white-card" style="border-radius:16px;padding:26px;margin-bottom:28px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:22px">
        <h3 style="font-size:19px;font-weight:700;color:#111">Most Popular Recipes</h3>
        <i class="fas fa-ellipsis-v" style="color:#aaa;cursor:pointer"></i>
    </div>
    
    <div style="display:flex;flex-direction:column;gap:20px;">
        @php
            // Mock highly polished recipes matching the Figma exactly if database has empty seeds
            $figmaRecipes = [
                ['Special Seafood Nasi Goreng', 'Main Course • 12k Views', '92%', 92],
                ['Authentic Soto Ayam Lamongan', 'Soup • 10.4k Views', '78%', 78],
                ['Madura Chicken Satay', 'Snack • 8.1k Views', '64%', 64],
            ];
        @endphp

        @foreach($figmaRecipes as $fr)
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <div style="display:flex;align-items:center;gap:12px">
                    <div style="width:40px;height:40px;border-radius:8px;background:#FFF0EC;color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:800;">
                        🍳
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#111">{{ $fr[0] }}</div>
                        <div style="font-size:12px;color:var(--text-m)">{{ $fr[1] }}</div>
                    </div>
                </div>
                <div style="font-size:15px;font-weight:800;color:#A03010">{{ $fr[2] }}</div>
            </div>
            <div style="height:10px;background:#F5F5F5;border-radius:5px;overflow:hidden;margin-left:52px;">
                <div style="width:{{ $fr[3] }}%;height:100%;background:#A03010;border-radius:5px;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Bottom Metric Boxes -->
<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;">
    <!-- Avg Difficulty -->
    <div class="white-card" style="display:flex;align-items:center;gap:16px;padding:20px;border-radius:16px;background:#F4FDF6;border:1px solid #D8F3DC;">
        <div style="width:46px;height:46px;background:#E8F5E9;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#2E7D32;font-size:20px;">
            <i class="fas fa-bolt"></i>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#777;letter-spacing:0.8px;">Avg. Difficulty</div>
            <div style="font-size:20px;font-weight:800;color:#111;margin-top:2px;">Beginner</div>
        </div>
    </div>

    <!-- Avg Cook Time -->
    <div class="white-card" style="display:flex;align-items:center;gap:16px;padding:20px;border-radius:16px;background:#FFFDF7;border:1px solid #FDF5E6;">
        <div style="width:46px;height:46px;background:#FFF9EF;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#FF9800;font-size:20px;">
            <i class="far fa-clock"></i>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#777;letter-spacing:0.8px;">Avg. Cook Time</div>
            <div style="font-size:20px;font-weight:800;color:#111;margin-top:2px;">24 mins</div>
        </div>
    </div>

    <!-- Engagement Rate -->
    <div class="white-card" style="display:flex;align-items:center;gap:16px;padding:20px;border-radius:16px;background:#F0F7FF;border:1px solid #D0E7FF;">
        <div style="width:46px;height:46px;background:#E3F2FD;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#1565C0;font-size:20px;">
            <i class="fas fa-chart-line"></i>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#777;letter-spacing:0.8px;">Engagement Rate</div>
            <div style="font-size:20px;font-weight:800;color:#111;margin-top:2px;">+12.4%</div>
        </div>
    </div>
</div>
@endsection
