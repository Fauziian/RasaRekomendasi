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
            'vip_starts_at'  => now(),
            'vip_ends_at'    => now()->addDays($transaction->vipPackage->duration_days),
        ]);

        // Send notification to User
        \App\Models\Notification::create([
            'user_id' => $transaction->user_id,
            'title' => 'Pembayaran VIP Disetujui!',
            'message' => "Pembayaran Anda untuk paket {$transaction->vipPackage->name} telah dikonfirmasi. Akun VIP Anda kini aktif!",
            'link' => route('vip.index')
        ]);

        // activateVip() dipanggil otomatis via Transaction::updated() boot hook
        return back()->with('success', "Pembayaran #{$transaction->invoice_number} berhasil dikonfirmasi. VIP user diaktifkan.");
    }

    public function reject(Transaction $transaction) {
        if ($transaction->payment_status !== 'pending') {
            return back()->withErrors(['error' => 'Transaksi ini tidak dalam status pending.']);
        }

        $transaction->update(['payment_status' => 'failed']);

        // Send notification to User
        \App\Models\Notification::create([
            'user_id' => $transaction->user_id,
            'title' => 'Pembayaran VIP Ditolak',
            'message' => "Pembayaran Anda untuk paket {$transaction->vipPackage->name} ditolak. Silakan hubungi dukungan jika ini kesalahan.",
            'link' => route('vip.index')
        ]);

        return back()->with('success', "Pembayaran #{$transaction->invoice_number} ditolak.");
    }
}
