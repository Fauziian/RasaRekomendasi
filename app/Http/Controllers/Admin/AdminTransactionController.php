<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class AdminTransactionController extends Controller
{
    public function index() {
        $transactions = Transaction::with('user','vipPackage')->latest()->paginate(15);
        $stats = ['total'=>Transaction::sum('amount'),'success'=>Transaction::where('payment_status','success')->sum('amount'),'count'=>Transaction::count()];
        return view('admin.transactions', compact('transactions','stats'));
    }
}
