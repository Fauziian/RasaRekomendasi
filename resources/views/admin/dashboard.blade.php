@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:28px">
    <div>
        <h1 style="font-size:32px;font-weight:700;color:#111;font-family:'Outfit',sans-serif">Kitchen Dashboard</h1>
        <p style="color:var(--text-m);margin-top:4px">Good morning, Admin. Here's what's happening today.</p>
    </div>
    <div style="display:flex;gap:12px">
        <button class="btn btn-white" style="font-size:13px;"><i class="far fa-calendar"></i> This Week</button>
        <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary" style="font-size:13px;background:var(--primary);color:#fff;"><i class="fas fa-plus"></i> Post Recipe</a>
    </div>
</div>

<!-- 6 Stats Cards Grid -->
<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;margin-bottom:28px">
    <!-- Card 1: TOTAL RESEP -->
    <div class="white-card" style="display:flex;justify-content:space-between;align-items:center;padding:24px;border-radius:16px;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:1px;margin-bottom:6px">Total Resep</div>
            <div style="font-size:34px;font-weight:800;color:#111;line-height:1;margin-bottom:6px">{{ number_format($stats['total_recipes']) }}</div>
            <div style="font-size:12px;font-weight:700;color:#2E7D32;"><i class="fas fa-arrow-trend-up"></i> +12% this week</div>
        </div>
        <div style="width:52px;height:52px;background:#FFF0EC;border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:20px;">
            <i class="fas fa-book-open"></i>
        </div>
    </div>

    <!-- Card 2: TOTAL USER -->
    <div class="white-card" style="display:flex;justify-content:space-between;align-items:center;padding:24px;border-radius:16px;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:1px;margin-bottom:6px">Total User</div>
            <div style="font-size:34px;font-weight:800;color:#111;line-height:1;margin-bottom:6px">{{ number_format($stats['total_users']) }}</div>
            <div style="font-size:12px;font-weight:700;color:#2E7D32;"><i class="fas fa-arrow-trend-up"></i> +5.2% this week</div>
        </div>
        <div style="width:52px;height:52px;background:#F4F2EB;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#777;font-size:20px;">
            <i class="fas fa-user-friends"></i>
        </div>
    </div>

    <!-- Card 3: USER VIP -->
    <div class="white-card" style="display:flex;justify-content:space-between;align-items:center;padding:24px;border-radius:16px;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:1px;margin-bottom:6px">User VIP</div>
            <div style="font-size:34px;font-weight:800;color:#111;line-height:1;margin-bottom:6px">{{ number_format($stats['vip_users']) }}</div>
            <div style="font-size:12px;font-weight:700;color:#E04D2C;"><i class="fas fa-crown"></i> 13% Conversion</div>
        </div>
        <div style="width:52px;height:52px;background:#FFF9EF;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#FF9800;font-size:20px;">
            <i class="fas fa-award"></i>
        </div>
    </div>

    <!-- Card 4: TOTAL CHEF -->
    <div class="white-card" style="display:flex;justify-content:space-between;align-items:center;padding:24px;border-radius:16px;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:1px;margin-bottom:6px">Total Chef</div>
            <div style="font-size:34px;font-weight:800;color:#111;line-height:1;margin-bottom:6px">{{ number_format($stats['total_chefs']) }}</div>
            <div style="font-size:12px;font-weight:600;color:#777;">Active Professionals</div>
        </div>
        <div style="width:52px;height:52px;background:#E8F5E9;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#2E7D32;font-size:20px;">
            <i class="fas fa-graduation-cap"></i>
        </div>
    </div>

    <!-- Card 5: TRANSAKSI -->
    <div class="white-card" style="display:flex;justify-content:space-between;align-items:center;padding:24px;border-radius:16px;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:1px;margin-bottom:6px">Transaksi</div>
            <div style="font-size:34px;font-weight:800;color:#111;line-height:1;margin-bottom:6px">{{ number_format($stats['total_transactions']) }}</div>
            <div style="font-size:12px;font-weight:600;color:#777;"><i class="far fa-calendar-alt"></i> Last 30 Days</div>
        </div>
        <div style="width:52px;height:52px;background:#F5F5F5;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#555;font-size:20px;">
            <i class="fas fa-credit-card"></i>
        </div>
    </div>

    <!-- Card 6: TOTAL PENDAPATAN -->
    <div class="white-card" style="display:flex;justify-content:space-between;align-items:center;padding:24px;border-radius:16px;">
        <div>
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;letter-spacing:1px;margin-bottom:6px">Total Pendapatan</div>
            <div style="font-size:28px;font-weight:800;color:#111;line-height:1.2;margin-bottom:6px;">
                Rp {{ $stats['total_revenue'] >= 1000000 ? number_format($stats['total_revenue']/1000000, 1) . 'M' : number_format($stats['total_revenue'], 0, ',', '.') }}
            </div>
            <div style="font-size:12px;font-weight:700;color:#2E7D32;"><i class="fas fa-arrow-trend-up"></i> +8% vs prev month</div>
        </div>
        <div style="width:52px;height:52px;background:#E8F5E9;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#2E7D32;font-size:20px;">
            <i class="fas fa-wallet"></i>
        </div>
    </div>
</div>

<!-- Transaction Trend & Best Seller Row -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:28px">
    <!-- Chart Card -->
    <div class="white-card" style="border-radius:16px;padding:26px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:22px">
            <h3 style="font-size:19px;font-weight:700;color:#111">Tren Transaksi & Revenue</h3>
            <select style="padding:6px 12px;border:1px solid var(--border);border-radius:8px;font-family:inherit;font-size:12px;outline:none;background:#F9F9F9;color:#555;font-weight:600;cursor:pointer;">
                <option>Last 6 Months</option>
                <option>Last 30 Days</option>
                <option>This Year</option>
            </select>
        </div>
        <!-- SVG Bar Chart -->
        <div style="height:190px;width:100%;margin-top:10px;">
            <svg viewBox="0 0 500 170" style="width:100%;height:100%">
                <!-- Background lines -->
                <line x1="0" y1="30" x2="500" y2="30" stroke="#F5F5F5" stroke-width="1" />
                <line x1="0" y1="70" x2="500" y2="70" stroke="#F5F5F5" stroke-width="1" />
                <line x1="0" y1="110" x2="500" y2="110" stroke="#F5F5F5" stroke-width="1" />
                <line x1="0" y1="140" x2="500" y2="140" stroke="#EEEEEE" stroke-width="1.5" />

                <!-- Bar Jan -->
                <rect x="25" y="100" width="34" height="40" rx="4" fill="#FFDDD6" />
                <text x="42" y="158" font-family="'Outfit',sans-serif" font-size="11" font-weight="600" fill="#bbb" text-anchor="middle">Jan</text>

                <!-- Bar Feb -->
                <rect x="105" y="80" width="34" height="60" rx="4" fill="#FFDDD6" />
                <text x="122" y="158" font-family="'Outfit',sans-serif" font-size="11" font-weight="600" fill="#bbb" text-anchor="middle">Feb</text>

                <!-- Bar Mar (Highlighted) -->
                <rect x="185" y="40" width="34" height="100" rx="4" fill="#A03010" />
                <text x="202" y="158" font-family="'Outfit',sans-serif" font-size="11" font-weight="700" fill="#777" text-anchor="middle">Mar</text>

                <!-- Bar Apr -->
                <rect x="265" y="70" width="34" height="70" rx="4" fill="#FFDDD6" />
                <text x="282" y="158" font-family="'Outfit',sans-serif" font-size="11" font-weight="600" fill="#bbb" text-anchor="middle">Apr</text>

                <!-- Bar May -->
                <rect x="345" y="55" width="34" height="85" rx="4" fill="#FFDDD6" />
                <text x="362" y="158" font-family="'Outfit',sans-serif" font-size="11" font-weight="600" fill="#bbb" text-anchor="middle">May</text>

                <!-- Bar Jun -->
                <rect x="425" y="45" width="34" height="95" rx="4" fill="#FFDDD6" />
                <text x="442" y="158" font-family="'Outfit',sans-serif" font-size="11" font-weight="600" fill="#bbb" text-anchor="middle">Jun</text>
            </svg>
        </div>
    </div>

    <!-- Best Seller Card -->
    <div class="white-card" style="border-radius:16px;padding:26px;display:flex;flex-direction:column;">
        <h3 style="font-size:19px;font-weight:700;color:#111;margin-bottom:22px">Best Selling VIP</h3>
        
        <div style="flex:1;display:flex;flex-direction:column;justify-content:center;gap:18px;">
            <!-- Progress Item 1 -->
            <div>
                <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:700;color:#333;margin-bottom:6px">
                    <span>Paket Chef 3 Bulan</span>
                    <span style="color:#777">58%</span>
                </div>
                <div style="height:8px;background:#EEEEEE;border-radius:4px;overflow:hidden;">
                    <div style="width:58%;height:100%;background:#A03010;border-radius:4px;"></div>
                </div>
            </div>

            <!-- Progress Item 2 -->
            <div>
                <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:700;color:#333;margin-bottom:6px">
                    <span>Paket Tahunan Master</span>
                    <span style="color:#777">32%</span>
                </div>
                <div style="height:8px;background:#EEEEEE;border-radius:4px;overflow:hidden;">
                    <div style="width:32%;height:100%;background:#FF9800;border-radius:4px;"></div>
                </div>
            </div>

            <!-- Progress Item 3 -->
            <div>
                <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:700;color:#333;margin-bottom:6px">
                    <span>Paket Bulanan Starter</span>
                    <span style="color:#777">10%</span>
                </div>
                <div style="height:8px;background:#EEEEEE;border-radius:4px;overflow:hidden;">
                    <div style="width:10%;height:100%;background:#777;border-radius:4px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transactions and Comments Grid -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    <!-- Recent Transactions Card -->
    <div class="white-card" style="border-radius:16px;padding:26px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
            <h3 style="font-size:19px;font-weight:700;color:#111">Transaksi Terbaru</h3>
            <a href="{{ route('admin.transactions.index') }}" style="color:var(--primary);font-size:13px;font-weight:700">Lihat Semua</a>
        </div>
        
        <div style="display:flex;flex-direction:column;gap:18px;">
            @forelse($recentTransactions as $t)
            <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:14px;border-bottom:1px solid #F8F9FA;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:50%;background:#FFF0EC;color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;">
                        {{ strtoupper(substr($t->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#333">{{ $t->user->name ?? 'Guest User' }}</div>
                        <div style="font-size:12px;color:var(--text-m)">{{ $t->vipPackage->name ?? 'Premium Plan' }} • {{ $t->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div style="font-size:15px;font-weight:800;color:#A03010">
                    Rp {{ number_format($t->amount, 0, ',', '.') }}
                </div>
            </div>
            @empty
            <!-- Fallback Static High-Fidelity Data to match Figma when database is not fully populated -->
            <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:14px;border-bottom:1px solid #F8F9FA;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:50%;background:#FFF0EC;color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;">
                        AR
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#333">Ahmad Rizky</div>
                        <div style="font-size:12px;color:var(--text-m)">Paket Master • BCA Transfer • 2 mins ago</div>
                    </div>
                </div>
                <div style="font-size:15px;font-weight:800;color:#A03010">Rp 450.000</div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:14px;border-bottom:1px solid #F8F9FA;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:50%;background:#F4F2EB;color:#777;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;">
                        SR
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#333">Siti Rahma</div>
                        <div style="font-size:12px;color:var(--text-m)">Paket Chef • OVO • 15 mins ago</div>
                    </div>
                </div>
                <div style="font-size:15px;font-weight:800;color:#A03010">Rp 125.000</div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:50%;background:#E8F5E9;color:#2E7D32;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;">
                        BS
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#333">Budi Santoso</div>
                        <div style="font-size:12px;color:var(--text-m)">Paket Starter • GoPay • 42 mins ago</div>
                    </div>
                </div>
                <div style="font-size:15px;font-weight:800;color:#A03010">Rp 45.000</div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Comments & Rating Card -->
    <div class="white-card" style="border-radius:16px;padding:26px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
            <h3 style="font-size:19px;font-weight:700;color:#111">Komentar & Rating</h3>
            <a href="{{ route('admin.moderation.index') }}" style="color:var(--primary);font-size:13px;font-weight:700">Moderasi</a>
        </div>
        
        <div style="display:flex;flex-direction:column;gap:18px;">
            @forelse($recentComments as $c)
            <div style="display:flex;align-items:flex-start;gap:12px;padding-bottom:14px;border-bottom:1px solid #F8F9FA;">
                <img src="{{ $c->user->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="">
                <div style="flex:1">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                        <span style="font-size:14px;font-weight:700;color:#333">{{ $c->user->name }}</span>
                        <span style="color:#FF9800;font-size:12px;">
                            @for($i=1; $i<=5; $i++)
                                <i class="{{ $i <= $c->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </span>
                    </div>
                    <p style="font-size:13px;color:#555;line-height:1.4;margin-bottom:4px;">"{{ Str::limit($c->comment, 80) }}"</p>
                    <div style="font-size:11px;color:var(--text-m)">Post: {{ $c->recipe->title ?? 'Resep' }} • {{ $c->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <!-- Fallback Static High-Fidelity Data to match Figma when database is not fully populated -->
            <div style="display:flex;align-items:flex-start;gap:12px;padding-bottom:14px;border-bottom:1px solid #F8F9FA;">
                <div style="width:36px;height:36px;border-radius:50%;background:#E2E8F0;display:flex;align-items:center;justify-content:center;font-weight:700;color:#475569;font-size:12px;">LP</div>
                <div style="flex:1">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                        <span style="font-size:14px;font-weight:700;color:#333">Larasati Putri</span>
                        <span style="color:#FF9800;font-size:11px;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                    </div>
                    <p style="font-size:13px;color:#555;line-height:1.4;margin-bottom:4px;">"Resep Rendang Daging Sapi dari Chef Arnold benar-benar mudah diikuti dan rasanya otentik..."</p>
                    <div style="font-size:11px;color:var(--text-m)">Post: Rendang Padang • 1 hour ago</div>
                </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <div style="width:36px;height:36px;border-radius:50%;background:#CBD5E1;display:flex;align-items:center;justify-content:center;font-weight:700;color:#334155;font-size:12px;">DW</div>
                <div style="flex:1">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                        <span style="font-size:14px;font-weight:700;color:#333">Dimas Wijaya</span>
                        <span style="color:#FF9800;font-size:11px;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></span>
                    </div>
                    <p style="font-size:13px;color:#555;line-height:1.4;margin-bottom:4px;">"Video tutorialnya sangat membantu untuk pemula seperti saya. Hanya saja daftar bahannya sedikit..."</p>
                    <div style="font-size:11px;color:var(--text-m)">Post: Sate Maranggi • 3 hours ago</div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
