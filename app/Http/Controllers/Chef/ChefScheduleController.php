<?php
namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\ChefSchedule;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefScheduleController extends Controller
{
    public function index() {
        $chefId = Auth::id();
        $schedules = ChefSchedule::where('chef_id', $chefId)->latest()->paginate(10);
        
        $totalBooked = ChefSchedule::where('chef_id', $chefId)->where('status', 'booked')->count();
        $availableSlots = ChefSchedule::where('chef_id', $chefId)->where('status', 'available')->where('available_date', '>=', today())->count();
        $completedCount = Consultation::where('chef_id', $chefId)->where('status', 'completed')->count();
        $earnings = 1500000 + ($completedCount * 150000);

        return view('chef.schedules.index', compact('schedules', 'totalBooked', 'availableSlots', 'earnings'));
    }

    // create() form is handled inline on index page via modal — no separate page needed
    public function create() {
        return redirect()->route('chef.schedules.index');
    }

    public function store(Request $request) {
        $request->validate([
            'consultation_date' => 'required|date|after_or_equal:today',
            'start_time'        => 'required',
            'end_time'          => 'required',
            'quota'             => 'required|integer|min:1',
        ]);

        ChefSchedule::create([
            'chef_id'              => Auth::id(),
            'available_date'       => $request->consultation_date,
            'available_time_start' => $request->start_time,
            'available_time_end'   => $request->end_time,
            'max_bookings'         => $request->quota,
            'status'               => 'available',
            'current_bookings'     => 0
        ]);

        return back()->with('success', 'Jadwal ketersediaan konsultasi berhasil ditambahkan!');
    }

    // show/edit/update: redirect back — managed via index page
    public function show($id) {
        return redirect()->route('chef.schedules.index');
    }

    public function edit($id) {
        return redirect()->route('chef.schedules.index');
    }

    public function update(Request $request, $id) {
        return redirect()->route('chef.schedules.index');
    }

    public function destroy($id) {
        $schedule = ChefSchedule::findOrFail($id);
        if ($schedule->chef_id !== Auth::id()) abort(403);
        
        if ($schedule->status === 'booked' || $schedule->current_bookings > 0) {
            return back()->with('error', 'Tidak dapat menghapus jadwal yang sudah dipesan oleh pengguna.');
        }
        
        $schedule->delete();
        return back()->with('success', 'Jadwal ketersediaan konsultasi berhasil dihapus.');
    }
}
