<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Recipe; use App\Models\Category;
use Illuminate\Http\Request;

class UserRecommendationController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('user.recommendations.wizard', compact('categories'));
    }

    public function results(Request $request) {
        $request->validate([
            'ingredients' => 'required|array',
            'difficulty'  => 'nullable|string',
            'max_time'    => 'nullable|integer',
        ]);

        $q = Recipe::published();
        
        // Exact ingredients match search logic
        if ($request->ingredients) {
            $q->where(function($query) use ($request) {
                foreach ($request->ingredients as $ing) {
                    $query->orWhere('ingredients', 'like', "%{$ing}%");
                }
            });
        }
        
        if ($request->difficulty) {
            $q->where('difficulty', $request->difficulty);
        }
        if ($request->max_time) {
            $q->where('prep_time', '<=', $request->max_time);
        }

        $recipes = $q->latest()->take(9)->get();
        return view('user.recommendations.results', compact('recipes'));
    }
}
