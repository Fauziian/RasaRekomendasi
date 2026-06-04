<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ChefSchedule as Schedule;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserConsultationController extends Controller
{
    public function index() {
        $consultations = Consultation::where('user_id', Auth::id())->with('chef')->latest()->paginate(15);
        $availableChefs = User::where('role', 'chef')->get();
        return view('user.consultations.index', compact('consultations', 'availableChefs'));
    }

    public function create(User $chef) {
        $schedules = Schedule::where('chef_id', $chef->id)->where('status', 'available')->get();
        return view('user.consultations.create', compact('chef', 'schedules'));
    }

    public function store(Request $request, User $chef) {
        $request->validate(['schedule_id'=>'required']);
        
        $schedule = Schedule::findOrFail($request->schedule_id);
        
        $consultation = Consultation::create([
            'user_id' => Auth::id(),
            'chef_id' => $chef->id,
            'schedule_id' => $schedule->id,
            'status' => 'active'
        ]);

        // Consume quota
        $schedule->update(['is_available' => false]);

        return redirect()->route('consultations.chat', $consultation)->with('success', 'Sesi konsultasi Anda berhasil dijadwalkan!');
    }

    public function chat(Consultation $consultation) {
        if ($consultation->user_id !== Auth::id()) abort(403);
        $messages = Message::where('consultation_id', $consultation->id)->orderBy('created_at', 'asc')->get();
        return view('user.consultations.chat', compact('consultation', 'messages'));
    }

    public function sendMessage(Request $request, Consultation $consultation) {
        if ($consultation->user_id !== Auth::id()) abort(403);
        $request->validate(['message'=>'required']);
        
        // Create message body field to match DB schema
        Message::create([
            'consultation_id' => $consultation->id,
            'sender_id' => Auth::id(),
            'sender_role' => 'user',
            'body' => $request->message,
            'type' => 'text',
        ]);
        return back();
    }
}
