<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Feedback;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('is_admin', false)->count(),
            'new_users_today' => User::where('is_admin', false)->whereDate('created_at', today())->count(),
            'new_users_month' => User::where('is_admin', false)->where('created_at', '>=', now()->startOfMonth())->count(),
            'mau' => User::where('is_admin', false)->where('last_login_at', '>=', now()->subDays(30))->count(),
            'total_loans' => Transaction::whereIn('type', ['lend', 'borrow'])->count(),
            'loan_volume' => (float) Transaction::whereIn('type', ['lend', 'borrow'])->sum('amount'),
            'open_balance' => (float) Contact::selectRaw('SUM(ABS(balance)) as total')->value('total'),
            'feedback' => Feedback::count(),
            'suspended_users' => User::where('status', 'suspended')->count(),
        ];

        $growthChart = collect(range(29, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'date' => $date->format('M d'),
                'count' => User::where('is_admin', false)->whereDate('created_at', $date)->count(),
            ];
        });

        $loanChart = collect(range(13, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'date' => $date->format('M d'),
                'count' => Transaction::whereDate('created_at', $date)->count(),
                'volume' => (float) Transaction::whereDate('created_at', $date)->sum('amount'),
            ];
        });

        $recentLoans = Transaction::with(['user', 'contact'])->latest()->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'growthChart', 'loanChart', 'recentLoans'));
    }
}
