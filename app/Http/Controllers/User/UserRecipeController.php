<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Recipe; use App\Models\Category;
use Illuminate\Http\Request;

class UserRecipeController extends Controller
{
    public function index(Request $request) {
        $q = Recipe::published();
        if ($request->q) $q->where('title', 'like', "%{$request->q}%");
        if ($request->category) $q->whereHas('category', function($c) use($request){ $c->where('slug', $request->category); });
        if ($request->difficulty) $q->where('difficulty', $request->difficulty);
        
        $recipes = $q->latest()->paginate(12);
        $categories = Category::all();
        return view('user.recipes.index', compact('recipes', 'categories'));
    }

    public function show(Recipe $recipe) {
        if ($recipe->status !== 'published') abort(404);

        if ($recipe->is_vip_content) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if (!$user || ($user->isUser() && !$user->hasActiveVip())) {
                return redirect()->route('vip.index')->with('error', 'Resep ini eksklusif untuk member VIP. Silakan upgrade paket Anda untuk mengakses resep ini.');
            }
        }

        $similar = Recipe::published()->where('category_id', $recipe->category_id)->where('id', '!=', $recipe->id)->take(3)->get();
        return view('user.recipes.show', compact('recipe', 'similar'));
    }

    public function saved() {
        $recipes = \Illuminate\Support\Facades\Auth::user()->savedRecipes()->latest()->paginate(12);
        $categories = Category::all();
        return view('user.recipes.saved', compact('recipes', 'categories'));
    }

    public function rate(Request $request, Recipe $recipe) {
        $request->validate(['rating'=>'required|integer|min:1|max:5','comment'=>'nullable']);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $exists = $recipe->ratings()->where('user_id', $user->id)->exists();
        if ($exists) {
            return back()->withErrors(['rating' => 'Anda sudah memberikan ulasan untuk resep ini.']);
        }

        $comment = $recipe->ratings()->create([
            'user_id' => $user->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false // Moderation required
        ]);

        // Send notification to all Admins (including the comment_rating_id)
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'title' => 'Ulasan Baru Masuk!',
                'message' => "{$user->name} memberikan ulasan {$request->rating} bintang pada resep Chef " . ($recipe->chef ? $recipe->chef->name : '') . ": \"{$recipe->title}\".",
                'link' => route('admin.moderation.index'), // Link to Admin Moderation Management
                'comment_rating_id' => $comment->id,
            ]);
        }

        return back()->with('success', 'Ulasan Anda berhasil dikirim dan sedang menunggu moderasi!');
    }

    public function save(Recipe $recipe) {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->isAdmin() || $user->isChef()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Hanya member yang dapat memfavoritkan resep.'
                ], 403);
            }
            return back()->with('error', 'Hanya member yang dapat memfavoritkan resep.');
        }

        $result = $user->savedRecipes()->toggle($recipe->id);
        $isSaved = count($result['attached']) > 0;

        if ($isSaved) {
            if ($recipe->chef) {
                \App\Models\Notification::create([
                    'user_id' => $recipe->chef_id,
                    'title' => 'Resep Anda Difavoritkan!',
                    'message' => "{$user->name} menyimpan resep Anda \"{$recipe->title}\" ke favorit mereka.",
                    'link' => route('chef.recipes.index')
                ]);
            }

            // Send notification to all Admins
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Resep Difavoritkan!',
                    'message' => "{$user->name} menyimpan resep Chef " . ($recipe->chef ? $recipe->chef->name : '') . " \"{$recipe->title}\" ke favorit mereka.",
                    'link' => route('admin.recipes.index')
                ]);
            }
        }

        if (request()->expectsJson()) {
            return response()->json([
                'saved'   => $isSaved,
                'message' => $isSaved ? 'Resep disimpan ke favorit!' : 'Resep dihapus dari favorit.'
            ]);
        }

        return back()->with('success', $isSaved ? 'Resep disimpan ke favorit!' : 'Resep dihapus dari favorit.');
    }
}
