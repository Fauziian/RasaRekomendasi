<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use App\Models\CommentRating;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_recipes'       => Recipe::count(),
            'total_users'         => User::where('role','user')->count(),
            'total_chefs'         => User::where('role','chef')->count(),
            'vip_users'           => User::where('is_vip',true)->count(),
            'total_comments'      => CommentRating::whereDate('created_at',today())->count(),
            'total_transactions'  => Transaction::count(),
            'total_revenue'       => Transaction::where('payment_status','success')->sum('amount'),
            'avg_rating'          => number_format(CommentRating::avg('rating') ?? 0, 1),
            'popular_recipes'     => Recipe::published()->popular()->take(5)->with('chef','category')->get(),
        ];
        $pendingComments = CommentRating::where('is_approved',false)->latest()->take(5)->with('user','recipe')->get();
        $recentTransactions = Transaction::latest()->take(3)->with('user','vipPackage')->get();
        $recentComments = CommentRating::latest()->take(2)->with('user','recipe')->get();

        return view('admin.dashboard', compact('stats','pendingComments','recentTransactions','recentComments'));
    }

    public function statistics()
    {
        $stats = [
            'total_recipes'   => Recipe::count(),
            'total_users'     => User::where('role','user')->count(),
            'total_chefs'     => User::where('role','chef')->count(),
            'vip_users'       => User::where('is_vip',true)->count(),
            'total_revenue'   => Transaction::where('payment_status','success')->sum('amount'),
            'total_transactions' => Transaction::count(),
            'avg_rating'      => number_format(CommentRating::avg('rating') ?? 0, 1),
            'popular_recipes' => Recipe::published()->popular()->take(5)->with('chef','category')->get(),
        ];
        return view('admin.statistics', compact('stats'));
    }
}
