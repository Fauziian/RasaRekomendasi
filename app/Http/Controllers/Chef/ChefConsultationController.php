<?php
namespace App\Http\Controllers\Chef;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefConsultationController extends Controller
{
    public function index() {
        $consultations = Consultation::where('chef_id', Auth::id())->with('user')->latest()->paginate(15);
        return view('chef.consultations.index', compact('consultations'));
    }
    public function chat(Consultation $consultation) {
        if ($consultation->chef_id !== Auth::id()) abort(403);
        $messages = Message::where('consultation_id', $consultation->id)->orderBy('created_at', 'asc')->get();
        return view('chef.consultations.chat', compact('consultation', 'messages'));
    }
    public function sendMessage(Request $request, Consultation $consultation) {
        if ($consultation->chef_id !== Auth::id()) abort(403);
        $request->validate(['message'=>'required']);
        Message::create([
            'consultation_id' => $consultation->id,
            'sender_id' => Auth::id(),
            'sender_role' => 'chef',
            'body' => $request->message,
            'type' => 'text',
        ]);
        return back();
    }
}
