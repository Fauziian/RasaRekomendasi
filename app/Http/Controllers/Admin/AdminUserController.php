<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request) {
        $q = User::query();
        if ($request->role) $q->where('role',$request->role);
        if ($request->search) $q->where('name','like',"%{$request->search}%")->orWhere('email','like',"%{$request->search}%");
        $users = $q->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    public function destroy(User $user) {
        $user->delete();
        return back()->with('success','Pengguna dihapus.');
    }
    public function update(Request $request, User $user) {
        $validated = $request->validate([
            'role'      => 'sometimes|in:admin,chef,user',
            'is_active' => 'sometimes|boolean',
            'is_vip'    => 'sometimes|boolean',
        ]);
        $user->update($validated);
        return back()->with('success','Pengguna diperbarui!');
    }
}
