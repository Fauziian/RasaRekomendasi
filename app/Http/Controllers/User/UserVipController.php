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
        // Create a pending transaction. Payment will be confirmed via callback.
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'vip_package_id' => $package->id,
            'amount' => $package->price,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('vip.index')->with('success', 'Transaksi dibuat. Silakan selesaikan pembayaran untuk mengaktifkan VIP.');
    }

    /**
     * Simulate payment gateway callback to confirm payment.
     * In production this would be a signed/secured webhook.
     */
    public function paymentCallback(Request $request, Transaction $transaction)
    {
        if ($transaction->payment_status === 'success') {
            return response('Already paid', 200);
        }

        $transaction->update([
            'payment_status' => 'success',
            'paid_at' => now(),
            'payment_gateway_log' => $request->all(),
        ]);

        return redirect()->route('vip.index')->with('success', 'Pembayaran diterima, akses VIP telah diaktifkan.');
    }
}
