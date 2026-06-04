<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CommentRating;
use Illuminate\Http\Request;

class AdminModerationController extends Controller
{
    public function index(Request $request) {
        $q = CommentRating::with('user','recipe');
        if ($request->search) $q->where('comment','like',"%{$request->search}%");
        $comments = $q->latest()->paginate(10);
        $stats = ['pending'=>CommentRating::where('is_approved',false)->count(),'approved'=>CommentRating::where('is_approved',true)->count(),'total'=>CommentRating::count()];
        return view('admin.moderation', compact('comments','stats'));
    }
    public function approve(CommentRating $comment) {
        $comment->update(['is_approved'=>true]);
        return back()->with('success','Komentar disetujui.');
    }
    public function destroy(CommentRating $comment) {
        $comment->delete();
        return back()->with('success','Komentar dihapus.');
    }
}
