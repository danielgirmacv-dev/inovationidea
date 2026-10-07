<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;

class DashboardController extends Controller
{
    public function __construct(private readonly AnalyticsService $analytics) {}

    public function index()
    {
        $kpi = $this->analytics->getKpiMetrics();
        $byDepartment = $this->analytics->getIdeasByDepartment();
        $byCategory = $this->analytics->getIdeasByCategory();
        $monthlyTrend = $this->analytics->getMonthlyTrend();
        $byStatus = $this->analytics->getIdeasByStatus();
        $recentSubmissions = $this->analytics->getRecentSubmissions(8);

        return view('admin.dashboard', compact(
            'kpi',
            'byDepartment',
            'byCategory',
            'monthlyTrend',
            'byStatus',
            'recentSubmissions'
        ));
    }
}
