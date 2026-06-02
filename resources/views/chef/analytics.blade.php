@extends('layouts.chef')
@section('title', 'Analytics')
@section('content')
<div style="margin-bottom:26px">
    <h1 style="font-size:28px;font-weight:700;color:#111">Analytics Dashboard</h1>
    <p style="color:var(--text-m);margin-top:4px">Pantau performa resep dan tingkat interaksi dengan audiens Anda secara real-time.</p>
</div>

<!-- Performance Metrics Grid -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-bottom:30px;">
    <!-- Card 1 -->
    <div class="white-card" style="margin-bottom:0; display:flex; align-items:center; gap:16px; border:1px solid #F0F0F0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="width:48px; height:48px; border-radius:12px; background:#E8F5E9; color:#2E7D32; display:flex; align-items:center; justify-content:center; font-size:20px;">
            <i class="far fa-eye"></i>
        </div>
        <div>
            <div style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.5px;">Total Recipe Views</div>
            <div style="font-size:22px; font-weight:800; color:#111; margin-top:2px;">14,820</div>
            <div style="font-size:11px; color:#2E7D32; font-weight:700; margin-top:4px; display:inline-flex; align-items:center; gap:3px;">
                <i class="fas fa-caret-up"></i> +12.4% <span style="color:#aaa; font-weight:500;">this week</span>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="white-card" style="margin-bottom:0; display:flex; align-items:center; gap:16px; border:1px solid #F0F0F0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="width:48px; height:48px; border-radius:12px; background:#FFF4E0; color:#FF9800; display:flex; align-items:center; justify-content:center; font-size:20px;">
            <i class="far fa-star"></i>
        </div>
        <div>
            <div style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.5px;">Average Rating</div>
            <div style="font-size:22px; font-weight:800; color:#111; margin-top:2px;">4.85 / 5</div>
            <div style="font-size:11px; color:#2E7D32; font-weight:700; margin-top:4px; display:inline-flex; align-items:center; gap:3px;">
                <i class="fas fa-caret-up"></i> +0.15 <span style="color:#aaa; font-weight:500;">points</span>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="white-card" style="margin-bottom:0; display:flex; align-items:center; gap:16px; border:1px solid #F0F0F0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="width:48px; height:48px; border-radius:12px; background:#FFF0EC; color:#FF5A36; display:flex; align-items:center; justify-content:center; font-size:20px;">
            <i class="far fa-heart"></i>
        </div>
        <div>
            <div style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.5px;">Times Bookmarked</div>
            <div style="font-size:22px; font-weight:800; color:#111; margin-top:2px;">1,248</div>
            <div style="font-size:11px; color:#2E7D32; font-weight:700; margin-top:4px; display:inline-flex; align-items:center; gap:3px;">
                <i class="fas fa-caret-up"></i> +8.2% <span style="color:#aaa; font-weight:500;">new saves</span>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="white-card" style="margin-bottom:0; display:flex; align-items:center; gap:16px; border:1px solid #F0F0F0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="width:48px; height:48px; border-radius:12px; background:#E1F5FE; color:#0288D1; display:flex; align-items:center; justify-content:center; font-size:20px;">
            <i class="far fa-comments"></i>
        </div>
        <div>
            <div style="font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.5px;">VIP Chats Completed</div>
            <div style="font-size:22px; font-weight:800; color:#111; margin-top:2px;">56 Sesi</div>
            <div style="font-size:11px; color:#2E7D32; font-weight:700; margin-top:4px; display:inline-flex; align-items:center; gap:3px;">
                <i class="fas fa-caret-up"></i> +14.5% <span style="color:#aaa; font-weight:500;">consultations</span>
            </div>
        </div>
    </div>
</div>

<!-- Grid Charts -->
<div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px; margin-bottom:24px;">
    <!-- Chart Mockup Card -->
    <div class="white-card" style="border:1px solid #F0F0F0;">
        <div class="card-hdr" style="margin-bottom:24px;">
            <div>
                <h3 style="font-size:18px; font-weight:800;">Tren Kunjungan Resep</h3>
                <p style="font-size:12px; color:var(--text-m); margin-top:2px;">Analisis mingguan jumlah penayangan seluruh resep Anda.</p>
            </div>
            <div style="display:flex; gap:8px;">
                <button class="btn btn-white btn-sm" style="font-weight:700; border-radius:8px;">7 Hari</button>
                <button class="btn btn-white btn-sm" style="font-weight:700; background:#FF5A36; color:#FFF; border-color:#FF5A36; border-radius:8px;">30 Hari</button>
            </div>
        </div>
        
        <!-- Premium SVG Line Chart Mock -->
        <div style="position:relative; width:100%; height:220px; background:#FAFAFA; border-radius:12px; display:flex; align-items:flex-end; padding:20px; overflow:hidden;">
            <!-- Grid lines -->
            <div style="position:absolute; width:100%; height:1px; background:#ECECEC; left:0; bottom:50px;"></div>
            <div style="position:absolute; width:100%; height:1px; background:#ECECEC; left:0; bottom:100px;"></div>
            <div style="position:absolute; width:100%; height:1px; background:#ECECEC; left:0; bottom:150px;"></div>
            <div style="position:absolute; width:100%; height:1px; background:#ECECEC; left:0; bottom:200px;"></div>

            <!-- Area Path with gradient -->
            <svg style="position:absolute; left:0; top:0; width:100%; height:100%;" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#FF5A36" stop-opacity="0.25"/>
                        <stop offset="100%" stop-color="#FF5A36" stop-opacity="0.0"/>
                    </linearGradient>
                </defs>
                <path d="M 0 80 Q 20 40 40 60 T 80 20 T 100 30 L 100 100 L 0 100 Z" fill="url(#chartGrad)"/>
                <path d="M 0 80 Q 20 40 40 60 T 80 20 T 100 30" fill="none" stroke="#FF5A36" stroke-width="2"/>
            </svg>
            
            <!-- Labels -->
            <div style="display:flex; justify-content:space-between; width:100%; font-size:10px; color:#aaa; font-weight:700; z-index:1;">
                <span>Minggu 1</span>
                <span>Minggu 2</span>
                <span>Minggu 3</span>
                <span>Minggu 4</span>
            </div>
        </div>
    </div>

    <!-- Rating Distribution Card -->
    <div class="white-card" style="border:1px solid #F0F0F0; display:flex; flex-direction:column; justify-content:space-between;">
        <div class="card-hdr" style="margin-bottom:12px;">
            <div>
                <h3 style="font-size:18px; font-weight:800;">Distribusi Rating</h3>
                <p style="font-size:12px; color:var(--text-m); margin-top:2px;">Berdasarkan ulasan terdaftar.</p>
            </div>
        </div>
        
        <!-- Bars -->
        <div style="display:flex; flex-direction:column; gap:12px;">
            <!-- 5 Star -->
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:12px; font-weight:700; width:34px;">5 <i class="fas fa-star" style="color:#FF9800; font-size:10px;"></i></span>
                <div style="flex:1; height:8px; background:#EEE; border-radius:4px; overflow:hidden;">
                    <div style="width:82%; height:100%; background:#2E7D32; border-radius:4px;"></div>
                </div>
                <span style="font-size:12px; color:#777; width:28px; text-align:right;">82%</span>
            </div>
            <!-- 4 Star -->
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:12px; font-weight:700; width:34px;">4 <i class="fas fa-star" style="color:#FF9800; font-size:10px;"></i></span>
                <div style="flex:1; height:8px; background:#EEE; border-radius:4px; overflow:hidden;">
                    <div style="width:12%; height:100%; background:#81C784; border-radius:4px;"></div>
                </div>
                <span style="font-size:12px; color:#777; width:28px; text-align:right;">12%</span>
            </div>
            <!-- 3 Star -->
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:12px; font-weight:700; width:34px;">3 <i class="fas fa-star" style="color:#FF9800; font-size:10px;"></i></span>
                <div style="flex:1; height:8px; background:#EEE; border-radius:4px; overflow:hidden;">
                    <div style="width:4%; height:100%; background:#FFD54F; border-radius:4px;"></div>
                </div>
                <span style="font-size:12px; color:#777; width:28px; text-align:right;">4%</span>
            </div>
            <!-- 2 Star -->
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:12px; font-weight:700; width:34px;">2 <i class="fas fa-star" style="color:#FF9800; font-size:10px;"></i></span>
                <div style="flex:1; height:8px; background:#EEE; border-radius:4px; overflow:hidden;">
                    <div style="width:1%; height:100%; background:#FFB74D; border-radius:4px;"></div>
                </div>
                <span style="font-size:12px; color:#777; width:28px; text-align:right;">1%</span>
            </div>
            <!-- 1 Star -->
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:12px; font-weight:700; width:34px;">1 <i class="fas fa-star" style="color:#FF9800; font-size:10px;"></i></span>
                <div style="flex:1; height:8px; background:#EEE; border-radius:4px; overflow:hidden;">
                    <div style="width:1%; height:100%; background:#E57373; border-radius:4px;"></div>
                </div>
                <span style="font-size:12px; color:#777; width:28px; text-align:right;">1%</span>
            </div>
        </div>
    </div>
</div>

<!-- Table of Popular Recipes -->
<div class="white-card" style="border:1px solid #F0F0F0;">
    <div class="card-hdr" style="margin-bottom:18px;">
        <div>
            <h3 style="font-size:18px; font-weight:800;">Resep Paling Populer</h3>
            <p style="font-size:12px; color:var(--text-m); margin-top:2px;">Koleksi resep Anda dengan performa penayangan dan keterlibatan tertinggi.</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Judul Resep</th>
                <th>Kategori</th>
                <th>Kunjungan</th>
                <th>Disimpan</th>
                <th>Rating Rata-Rata</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Rendang Daging Sapi Panggang</strong></td>
                <td>Masakan Indonesia</td>
                <td>4.5K views</td>
                <td>320 kali</td>
                <td style="color:#FF9800; font-weight:700;"><i class="fas fa-star"></i> 4.9 (12 ulasan)</td>
            </tr>
            <tr>
                <td><strong>Ramen Tonkotsu Homemade</strong></td>
                <td>Masakan Internasional</td>
                <td>3.8K views</td>
                <td>280 kali</td>
                <td style="color:#FF9800; font-weight:700;"><i class="fas fa-star"></i> 4.8 (9 ulasan)</td>
            </tr>
            <tr>
                <td><strong>Udang Saus Padang Pedas</strong></td>
                <td>Seafood</td>
                <td>3.2K views</td>
                <td>240 kali</td>
                <td style="color:#FF9800; font-weight:700;"><i class="fas fa-star"></i> 4.7 (7 ulasan)</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
