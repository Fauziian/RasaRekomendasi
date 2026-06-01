<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index()
    {
        $trending   = Recipe::published()->freeContent()->popular()->take(3)->with('chef', 'category')->get();
        $categories = Category::withCount('recipes')->orderByDesc('recipes_count')->take(6)->get();
        $newest     = Recipe::published()->latest()->take(6)->with('chef', 'category')->get();

        return view('user.home', compact('trending', 'categories', 'newest'));
    }
}
