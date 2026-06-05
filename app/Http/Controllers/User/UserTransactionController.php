<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserTransactionController extends Controller
{
    public function index() {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('vipPackage')
            ->latest()
            ->paginate(15);
        return view('user.transactions.index', compact('transactions'));
    }
}
