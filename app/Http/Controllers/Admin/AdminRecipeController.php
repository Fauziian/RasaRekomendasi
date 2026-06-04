<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Recipe; use App\Models\Category; use App\Models\User;
use Illuminate\Http\Request;

class AdminRecipeController extends Controller
{
    public function index(Request $request) {
        $q = Recipe::with('chef','category');
        if ($request->search) $q->where('title','like',"%{$request->search}%");
        if ($request->category) $q->where('category_id',$request->category);
        $recipes = $q->latest()->paginate(10);
        $categories = Category::all();
        return view('admin.recipes.index', compact('recipes','categories'));
    }
    public function create() {
        $categories = Category::all();
        $chefs = User::where('role','chef')->get();
        return view('admin.recipes.form', compact('categories','chefs'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required','description'=>'required','category_id'=>'required',
            'chef_id'=>'required','difficulty'=>'required','prep_time'=>'required|integer',
            'cook_time'=>'required|integer','calories'=>'nullable|integer','servings'=>'nullable|integer',
            'status'=>'required','is_vip_content'=>'boolean',
        ]);
        $data['ingredients'] = $request->ingredients ?? [];
        $data['cooking_steps'] = $request->cooking_steps ?? [];
        $data['allergens'] = $request->allergens ?? [];
        $data['is_vip_content'] = $request->boolean('is_vip_content');
        Recipe::create($data);
        return redirect()->route('admin.recipes.index')->with('success','Resep berhasil ditambahkan!');
    }
    public function edit(Recipe $recipe) {
        $categories = Category::all();
        $chefs = User::where('role','chef')->get();
        return view('admin.recipes.form', compact('recipe','categories','chefs'));
    }
    public function update(Request $request, Recipe $recipe) {
        $data = $request->validate([
            'title'=>'required','description'=>'required','category_id'=>'required',
            'difficulty'=>'required','prep_time'=>'required|integer','cook_time'=>'required|integer',
            'status'=>'required',
        ]);
        $data['is_vip_content'] = $request->boolean('is_vip_content');
        $recipe->update($data);
        return redirect()->route('admin.recipes.index')->with('success','Resep berhasil diperbarui!');
    }
    public function destroy(Recipe $recipe) {
        $recipe->delete();
        return redirect()->route('admin.recipes.index')->with('success','Resep dihapus.');
    }
}
