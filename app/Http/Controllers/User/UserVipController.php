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
            'payment_method' => 'required|in:e_wallet,bank_transfer,credit_card,qris',
            'invoice_number' => 'nullable|string|max:50',
        ]);

        $amount = $package->price + round($package->price * 0.01) - round($package->price * 0.15);

        // Buat transaksi dengan status PENDING — VIP belum diaktifkan
        $transaction = Transaction::create([
            'invoice_number' => $request->invoice_number ?? Transaction::generateInvoiceNumber(),
            'user_id'        => Auth::id(),
            'vip_package_id' => $package->id,
            'amount'         => $amount,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Arahkan ke halaman simulator pembayaran
        return redirect()->route('vip.simulator', $transaction)
            ->with('success', 'Transaksi dibuat! Silakan selesaikan pembayaran Anda.');
    }

    public function pendingPayment(Transaction $transaction) {
        if ($transaction->user_id !== Auth::id()) abort(403);
        return view('user.vip.payment_pending', compact('transaction'));
    }

    public function simulator(Transaction $transaction) {
        if ($transaction->user_id !== Auth::id()) abort(403);
        return view('user.vip.simulator', compact('transaction'));
    }

    public function webhook(Request $request) {
        $request->validate([
            'invoice_number' => 'required|string',
            'status'         => 'required|in:success,failed',
        ]);

        $transaction = Transaction::where('invoice_number', $request->invoice_number)->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction->payment_status === 'pending') {
            if ($request->status === 'success') {
                $transaction->update([
                    'payment_status' => 'success',
                    'paid_at'        => now(),
                    'vip_starts_at'  => now(),
                    'vip_ends_at'    => now()->addDays($transaction->vipPackage->duration_days),
                ]);
            } else {
                $transaction->update([
                    'payment_status' => 'failed',
                ]);
            }
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }

    public function getTransactionStatus(Transaction $transaction) {
        if ($transaction->user_id !== Auth::id()) abort(403);
        return response()->json([
            'status' => $transaction->payment_status
        ]);
    }

    public function success(Transaction $transaction) {
        if ($transaction->user_id !== Auth::id()) abort(403);
        if ($transaction->payment_status !== 'success') {
            return redirect()->route('vip.index')->with('error', 'Transaksi belum selesai.');
        }
        return view('user.vip.success', compact('transaction'));
    }
}
