<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\VipPackage;
use Illuminate\Http\Request;

class AdminVipPackageController extends Controller
{
    public function index() {
        $packages = VipPackage::latest()->paginate(20);
        return view('admin.vip_packages.index', compact('packages'));
    }

    public function create() {
        return view('admin.vip_packages.form', ['package' => null]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'description'   => 'nullable|string',
            'features'      => 'nullable|string',
            'is_active'     => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        VipPackage::create($data);
        return redirect()->route('admin.vip-packages.index')->with('success', 'Paket VIP berhasil ditambahkan.');
    }

    public function edit(VipPackage $vipPackage) {
        return view('admin.vip_packages.form', ['package' => $vipPackage]);
    }

    public function update(Request $request, VipPackage $vipPackage) {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'description'   => 'nullable|string',
            'features'      => 'nullable|string',
            'is_active'     => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $vipPackage->update($data);
        return redirect()->route('admin.vip-packages.index')->with('success', 'Paket VIP berhasil diperbarui.');
    }

    public function destroy(VipPackage $vipPackage) {
        $vipPackage->delete();
        return back()->with('success', 'Paket VIP berhasil dihapus.');
    }

    public function toggle(VipPackage $vipPackage) {
        $vipPackage->update(['is_active' => !$vipPackage->is_active]);
        return back()->with('success', 'Status paket diperbarui.');
    }
}
