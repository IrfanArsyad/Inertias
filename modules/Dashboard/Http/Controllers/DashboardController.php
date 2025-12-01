<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard::Dashboard', [
            'stats' => [
                'total_users' => 1234,
                'total_orders' => 567,
                'revenue' => 45678,
                'growth' => 12.5
            ]
        ]);
    }
}
