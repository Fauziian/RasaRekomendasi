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
        $packages = VipPackage::where('is_active', true)->get();
        return view('user.vip.packages', compact('packages'));
    }

    public function checkout(VipPackage $package) {
        return view('user.vip.checkout', compact('package'));
    }

    public function processCheckout(Request $request, VipPackage $package) {
        $request->validate([
            'payment_method' => 'required|in:transfer,qris,virtual_account',
        ]);

        // Buat transaksi dengan status PENDING — VIP belum diaktifkan
        $transaction = Transaction::create([
            'user_id'        => Auth::id(),
            'vip_package_id' => $package->id,
            'amount'         => $package->price,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Arahkan ke halaman menunggu pembayaran
        return redirect()->route('transactions.pending', $transaction)
            ->with('success', 'Transaksi dibuat! Silakan selesaikan pembayaran Anda.');
    }

    public function pendingPayment(Transaction $transaction) {
        if ($transaction->user_id !== Auth::id()) abort(403);
        return view('user.vip.payment_pending', compact('transaction'));
    }
}
