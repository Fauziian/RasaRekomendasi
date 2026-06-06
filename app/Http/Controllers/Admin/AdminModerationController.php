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
        $comment->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        // Send notification to the Chef
        $recipe = $comment->recipe;
        if ($recipe && $recipe->chef) {
            \App\Models\Notification::create([
                'user_id' => $recipe->chef_id,
                'title' => 'Ulasan Baru Masuk!',
                'message' => "{$comment->user->name} memberikan ulasan {$comment->rating} bintang pada resep Anda: \"{$recipe->title}\".",
                'link' => route('chef.recipes.index') // Link to Chef Recipe Management
            ]);
        }

        // Mark associated admin notifications as read
        \App\Models\Notification::where('comment_rating_id', $comment->id)->update([
            'is_read' => true
        ]);

        return back()->with('success', 'Komentar disetujui.');
    }
    public function destroy(CommentRating $comment) {
        // Delete associated admin notifications
        \App\Models\Notification::where('comment_rating_id', $comment->id)->delete();

        $comment->delete();
        return back()->with('success', 'Komentar dihapus.');
    }
}
