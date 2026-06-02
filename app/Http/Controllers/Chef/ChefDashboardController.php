<?php
namespace App\Http\Controllers\Chef;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Consultation;
use App\Models\ChefSchedule;
use Illuminate\Support\Facades\Auth;

class ChefDashboardController extends Controller
{
    public function index()
    {
        $chefId = Auth::id();
        
        // Count available upcoming slots (today or in the future)
        $availableSlots = ChefSchedule::where('chef_id', $chefId)
            ->where('status', 'available')
            ->where('available_date', '>=', today())
            ->count();
            
        // Count total slots scheduled/added for today
        $todaySlotsAdded = ChefSchedule::where('chef_id', $chefId)
            ->where('available_date', today())
            ->count();

        // Total Bookings: All non-cancelled consultations
        $totalBookings = Consultation::where('chef_id', $chefId)
            ->where('status', '!=', 'cancelled')
            ->count();

        // Sessions today: consultations scheduled for today
        $sessionsToday = Consultation::where('chef_id', $chefId)
            ->whereHas('schedule', function ($q) {
                $q->where('available_date', today());
            })
            ->where('status', '!=', 'cancelled')
            ->count();

        // Active Chats: Consultation sessions that are confirmed or ongoing
        $activeChats = Consultation::where('chef_id', $chefId)
            ->whereIn('status', ['confirmed', 'ongoing'])
            ->count();

        $stats = [
            'available_slots'  => $availableSlots,
            'today_slots_added'=> $todaySlotsAdded,
            'total_bookings'   => $totalBookings,
            'sessions_today'   => $sessionsToday,
            'active_chats'     => $activeChats,
        ];

        // Fetch upcoming consultations (Jadwal Konsultasi Terdekat)
        $upcomingConsultations = Consultation::where('chef_id', $chefId)
            ->whereIn('status', ['pending', 'confirmed', 'ongoing'])
            ->with(['user', 'schedule'])
            ->get()
            ->sortBy(function($consultation) {
                return $consultation->schedule ? $consultation->schedule->available_date->toDateString() . ' ' . $consultation->schedule->available_time_start : '9999-12-31';
            })
            ->take(3);

        // Fetch VIP bookings
        $vipBookings = Consultation::where('chef_id', $chefId)
            ->whereHas('user', function($q) {
                $q->where('is_vip', true);
            })
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        $myRecipes = Recipe::where('chef_id', $chefId)->latest()->take(5)->get();

        return view('chef.dashboard', compact('stats', 'upcomingConsultations', 'vipBookings', 'myRecipes'));
    }

    public function analytics()
    {
        return view('chef.analytics');
    }

    public function earnings()
    {
        return view('chef.earnings');
    }
}

