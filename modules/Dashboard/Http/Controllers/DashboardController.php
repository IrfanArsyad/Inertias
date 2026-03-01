<?php

declare(strict_types=1);

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Modules\Dashboard\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,
    ) {}

    public function index()
    {
        return Inertia::render('Dashboard::Dashboard', [
            'userName' => auth()->user()->name,
            'stats' => $this->dashboardService->getStats(),
            'roleDistribution' => $this->dashboardService->getRoleDistribution(),
            'recentUsers' => $this->dashboardService->getRecentUsers(),
            'growthTrend' => $this->dashboardService->getGrowthTrend(),
        ]);
    }
}
