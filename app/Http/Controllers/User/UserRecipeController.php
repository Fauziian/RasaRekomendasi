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
        if (!$recipe->status == 'published') abort(404);
        $similar = Recipe::published()->where('category_id', $recipe->category_id)->where('id', '!=', $recipe->id)->take(3)->get();
        return view('user.recipes.show', compact('recipe', 'similar'));
    }

    public function rate(Request $request, Recipe $recipe) {
        $request->validate(['rating'=>'required|integer|min:1|max:5','comment'=>'nullable']);
        $recipe->ratings()->create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false // Moderation required
        ]);
        return back()->with('success', 'Ulasan Anda berhasil dikirim dan sedang menunggu moderasi!');
    }

    public function save(Recipe $recipe) {
        $user   = \Illuminate\Support\Facades\Auth::user();
        $result = $user->savedRecipes()->toggle($recipe->id);
        $isSaved = count($result['attached']) > 0;

        if (request()->expectsJson()) {
            return response()->json([
                'saved'   => $isSaved,
                'message' => $isSaved ? 'Resep disimpan ke favorit!' : 'Resep dihapus dari favorit.'
            ]);
        }

        return back()->with('success', $isSaved ? 'Resep disimpan ke favorit!' : 'Resep dihapus dari favorit.');
    }
}
