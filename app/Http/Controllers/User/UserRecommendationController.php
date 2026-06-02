<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;

class UserRecommendationController extends Controller
{
    /** Show the wizard preference input page */
    public function index()
    {
        $categories = Category::all();
        return view('user.recommendations.wizard', compact('categories'));
    }

    /**
     * POST from wizard → redirect to GET results (PRG pattern)
     * Converts wizard fields (ingredients[], difficulty, max_time)
     * into GET query params so the filter sidebar can work on results page.
     */
    public function submit(Request $request)
    {
        $params = array_filter([
            'difficulty' => $request->input('difficulty'),
            'max_time'   => $request->input('max_time'),
        ]);

        // Pass ingredients as keyword filters
        $keywords = $request->input('ingredients', []);
        if (!empty($keywords)) {
            $params['keywords'] = $keywords;
        }

        return redirect()->route('recommendations.results', $params);
    }

    /**
     * GET results page — shows recipes filtered by sidebar params.
     * Params: difficulty, max_time, categories[], keywords[]
     */
    public function results(Request $request)
    {
        $categories  = Category::all();
        $difficulty  = $request->input('difficulty');
        $maxTime     = $request->input('max_time');
        $categoryIds = $request->input('categories', []);
        $keywords    = $request->input('keywords', []);

        // ── Build query ──────────────────────────────────────────
        $query = Recipe::published()->with(['category', 'chef', 'tags']);

        if ($difficulty) {
            $query->where('difficulty', $difficulty);
        }

        if ($maxTime) {
            $query->withInTime((int) $maxTime);
        }

        if (!empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        // Keyword search (from wizard ingredients/flavor picks)
        if (!empty($keywords)) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $kw) {
                    $kw = trim($kw);
                    if ($kw === '') continue;
                    $q->orWhere('title',       'like', "%{$kw}%")
                      ->orWhere('description',  'like', "%{$kw}%")
                      ->orWhere('ingredients',  'like', "%{$kw}%")
                      ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$kw}%"))
                      ->orWhereHas('tags',     fn($t) => $t->where('name', 'like', "%{$kw}%"));
                }
            });
        }

        $recipes = $query->take(12)->get();

        // ── Match score ──────────────────────────────────────────
        $scoredRecipes = $recipes->map(function (Recipe $recipe) use ($difficulty, $maxTime, $categoryIds, $keywords) {
            $score    = 0;
            $maxScore = 0;

            if ($difficulty) {
                $maxScore += 40;
                $score    += ($recipe->difficulty === $difficulty) ? 40 : 0;
            }
            if ($maxTime) {
                $maxScore += 30;
                $score    += ($recipe->total_time <= (int)$maxTime) ? 30 : 0;
            }
            if (!empty($categoryIds)) {
                $maxScore += 30;
                $score    += in_array($recipe->category_id, $categoryIds) ? 30 : 0;
            }
            if (!empty($keywords)) {
                $haystack = strtolower(
                    $recipe->title . ' ' .
                    $recipe->description . ' ' .
                    ($recipe->category->name ?? '') . ' ' .
                    implode(' ', array_column($recipe->ingredients ?? [], 'name')) . ' ' .
                    $recipe->tags->pluck('name')->implode(' ')
                );
                foreach ($keywords as $kw) {
                    $maxScore += 10;
                    if (str_contains($haystack, strtolower(trim($kw)))) {
                        $score += 10;
                    }
                }
            }

            $matchPercent = ($maxScore > 0)
                ? (int) round(($score / $maxScore) * 39 + 60)
                : rand(78, 98);

            $recipe->match_percent = min($matchPercent, 99);
            return $recipe;
        })->sortByDesc('match_percent')->values();

        return view('user.recommendations.results', compact(
            'scoredRecipes',
            'categories',
            'difficulty',
            'maxTime',
            'categoryIds',
            'keywords'
        ));
    }
}
