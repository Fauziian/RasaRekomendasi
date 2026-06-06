<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $query = Auth::user()->visibleNotifications();
        if (Auth::user()->role === 'admin') {
            $query = $query->with('commentRating.user', 'commentRating.recipe');
        }
        $notifications = $query->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function read(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        if ($notification->link) {
            return redirect($notification->link);
        }

        return redirect()->route('notifications.index');
    }

    public function markAllRead()
    {
        Auth::user()->visibleNotifications()->where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }
}
