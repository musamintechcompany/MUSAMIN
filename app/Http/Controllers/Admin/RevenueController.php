<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index()
    {
        $totalRevenue = CoinTransaction::where('status', 'approved')->sum('amount');
        $todayRevenue = CoinTransaction::where('status', 'approved')
            ->whereDate('completed_at', today())
            ->sum('amount');
        $monthRevenue = CoinTransaction::where('status', 'approved')
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->sum('amount');
        $lastMonthRevenue = CoinTransaction::where('status', 'approved')
            ->whereMonth('completed_at', now()->subMonth()->month)
            ->whereYear('completed_at', now()->subMonth()->year)
            ->sum('amount');
        $lastYearRevenue = CoinTransaction::where('status', 'approved')
            ->whereYear('completed_at', now()->subYear()->year)
            ->sum('amount');

        return view('management.portal.admin.revenue.index', compact(
            'totalRevenue', 
            'todayRevenue', 
            'monthRevenue',
            'lastMonthRevenue',
            'lastYearRevenue'
        ));
    }
}