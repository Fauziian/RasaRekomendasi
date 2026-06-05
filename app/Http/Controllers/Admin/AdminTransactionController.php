<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class AdminTransactionController extends Controller
{
    public function index() {
        $transactions = Transaction::with('user', 'vipPackage')->latest()->paginate(15);
        $stats = [
            'total'   => Transaction::sum('amount'),
            'success' => Transaction::where('payment_status', 'success')->sum('amount'),
            'pending' => Transaction::where('payment_status', 'pending')->count(),
            'count'   => Transaction::count(),
        ];
        return view('admin.transactions', compact('transactions', 'stats'));
    }

    public function approve(Transaction $transaction) {
        if ($transaction->payment_status !== 'pending') {
            return back()->withErrors(['error' => 'Transaksi ini tidak dalam status pending.']);
        }

        $transaction->update([
            'payment_status' => 'success',
            'paid_at'        => now(),
        ]);

        // activateVip() dipanggil otomatis via Transaction::updated() boot hook
        return back()->with('success', "Pembayaran #{$transaction->invoice_number} berhasil dikonfirmasi. VIP user diaktifkan.");
    }

    public function reject(Transaction $transaction) {
        if ($transaction->payment_status !== 'pending') {
            return back()->withErrors(['error' => 'Transaksi ini tidak dalam status pending.']);
        }

        $transaction->update(['payment_status' => 'failed']);
        return back()->with('success', "Pembayaran #{$transaction->invoice_number} ditolak.");
    }
}
