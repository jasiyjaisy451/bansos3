<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRecipients = Recipient::count();
        $distributedCount = Recipient::where('is_distributed', true)->count();
        $pendingCount = $totalRecipients - $distributedCount;

        $uniformCount = Recipient::where('uniform_received', true)->count();
        $shoesCount = Recipient::where('shoes_received', true)->count();
        $bagCount = Recipient::where('bag_received', true)->count();

        $recentDistributions = Recipient::where('is_distributed', true)
            ->orderBy('distributed_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalRecipients',
            'distributedCount',
            'pendingCount',
            'uniformCount',
            'shoesCount',
            'bagCount',
            'recentDistributions'
        ));
    }

    public function dashboarduser()
    {
        $totalRecipients = Recipient::count();
        $distributedCount = Recipient::where('is_distributed', true)->count();
        $pendingCount = $totalRecipients - $distributedCount;

        $uniformCount = Recipient::where('uniform_received', true)->count();
        $shoesCount = Recipient::where('shoes_received', true)->count();
        $bagCount = Recipient::where('bag_received', true)->count();

        $recentDistributions = Recipient::where('is_distributed', true)
            ->orderBy('distributed_at', 'desc')
            ->limit(10)
            ->get();

        return view('pemantau.dashboard', compact(
            'totalRecipients',
            'distributedCount',
            'pendingCount',
            'uniformCount',
            'shoesCount',
            'bagCount',
            'recentDistributions'
        ));
    }
}
