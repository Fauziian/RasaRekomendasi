<?php
namespace App\Http\Controllers\Chef;
use App\Http\Controllers\Controller;
use App\Models\Recipe; use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefRecipeController extends Controller
{
    public function index() {
        $recipes = Recipe::where('chef_id', Auth::id())->latest()->paginate(10);
        return view('chef.recipes.index', compact('recipes'));
    }
    public function create() {
        $categories = Category::all();
        return view('chef.recipes.form', compact('categories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required','description'=>'required','category_id'=>'required',
            'difficulty'=>'required','prep_time'=>'required|integer','cook_time'=>'required|integer',
            'calories'=>'nullable|integer','servings'=>'nullable|integer','status'=>'required',
        ]);
        $data['chef_id'] = Auth::id();
        $data['ingredients'] = $request->ingredients ?? [];
        $data['cooking_steps'] = $request->cooking_steps ?? [];
        $data['is_vip_content'] = $request->boolean('is_vip_content');
        Recipe::create($data);
        return redirect()->route('chef.recipes.index')->with('success','Resep berhasil ditambahkan!');
    }
    public function edit(Recipe $recipe) {
        if($recipe->chef_id !== Auth::id()) abort(403);
        $categories = Category::all();
        return view('chef.recipes.form', compact('recipe','categories'));
    }
    public function update(Request $request, Recipe $recipe) {
        if($recipe->chef_id !== Auth::id()) abort(403);
        $data = $request->validate([
            'title'=>'required','description'=>'required','category_id'=>'required',
            'difficulty'=>'required','prep_time'=>'required|integer','cook_time'=>'required|integer',
            'status'=>'required',
        ]);
        $data['is_vip_content'] = $request->boolean('is_vip_content');
        $recipe->update($data);
        return redirect()->route('chef.recipes.index')->with('success','Resep berhasil diperbarui!');
    }
    public function destroy(Recipe $recipe) {
        if($recipe->chef_id !== Auth::id()) abort(403);
        $recipe->delete();
        return redirect()->route('chef.recipes.index')->with('success','Resep dihapus.');
    }
}
