<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\VipPackage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVipController extends Controller
{
    public function index() {
        $packages = VipPackage::all();
        return view('user.vip.packages', compact('packages'));
    }

    public function checkout(VipPackage $package) {
        return view('user.vip.checkout', compact('package'));
    }

    public function processCheckout(Request $request, VipPackage $package) {
        $request->validate(['payment_method'=>'required']);
        
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'vip_package_id' => $package->id,
            'amount' => $package->price,
            'payment_status' => 'success', // Simulated success payment gateway integration
            'payment_method' => $request->payment_method
        ]);

        // Enable user VIP access
        $user = Auth::user();
        $user->update(['is_vip' => true]);

        return redirect()->route('vip.index')->with('success', 'Selamat! Anda sekarang resmi menjadi Member VIP RasaRekomendasi! 🎉');
    }
}
