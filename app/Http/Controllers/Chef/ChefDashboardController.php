<?php
namespace App\Http\Controllers\Chef;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class ChefDashboardController extends Controller
{
    public function index()
    {
        $chefId = Auth::id();
        $stats = [
            'total_recipes'    => Recipe::where('chef_id', $chefId)->count(),
            'published_recipes'=> Recipe::where('chef_id', $chefId)->published()->count(),
            'draft_recipes'    => Recipe::where('chef_id', $chefId)->where('status', 'draft')->count(),
            'active_chats'     => Consultation::where('chef_id', $chefId)->where('status', 'active')->count(),
        ];
        $myRecipes = Recipe::where('chef_id', $chefId)->latest()->take(5)->get();
        $recentChats = Consultation::where('chef_id', $chefId)->with('user')->latest()->take(5)->get();

        return view('chef.dashboard', compact('stats', 'myRecipes', 'recentChats'));
    }
}
