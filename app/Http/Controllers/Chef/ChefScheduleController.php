<?php
namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\ChefSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefScheduleController extends Controller
{
    public function index() {
        $schedules = ChefSchedule::where('chef_id', Auth::id())->latest()->paginate(10);
        return view('chef.schedules.index', compact('schedules'));
    }

    public function store(Request $request) {
        $request->validate([
            'consultation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
            'quota' => 'required|integer|min:1',
        ]);

        ChefSchedule::create([
            'chef_id' => Auth::id(),
            'consultation_date' => $request->consultation_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'quota' => $request->quota,
            'is_available' => true
        ]);

        return back()->with('success', 'Jadwal konsultasi ditambahkan!');
    }

    public function destroy($id) {
        $schedule = ChefSchedule::findOrFail($id);
        if ($schedule->chef_id !== Auth::id()) abort(403);
        $schedule->delete();
        return back()->with('success', 'Jadwal konsultasi dihapus.');
    }
}
