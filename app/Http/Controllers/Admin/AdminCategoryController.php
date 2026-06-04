<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index() {
        $categories = Category::withCount('recipes')->orderByDesc('recipes_count')->paginate(12);
        return view('admin.categories.index', compact('categories'));
    }
    public function store(Request $request) {
        $request->validate(['name'=>'required|unique:categories','description'=>'nullable','icon'=>'nullable']);
        Category::create($request->only('name','description','icon'));
        return back()->with('success','Kategori berhasil ditambahkan!');
    }
    public function update(Request $request, Category $category) {
        $request->validate(['name'=>"required|unique:categories,name,{$category->id}",'description'=>'nullable']);
        $category->update($request->only('name','description','icon'));
        return back()->with('success','Kategori diperbarui!');
    }
    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success','Kategori dihapus.');
    }
}
