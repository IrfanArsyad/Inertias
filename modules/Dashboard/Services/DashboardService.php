<?php

declare(strict_types=1);

namespace Modules\Dashboard\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * @return array<string, int|float>
     */
    public function getStats(): array
    {
        $totalUsers = User::count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;
        $usersWithoutRole = User::whereNull('role_id')->count();

        $newThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $newLastMonth = User::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth(),
        ])->count();

        $growthPercentage = $newLastMonth > 0
            ? (int) round(($newThisMonth - $newLastMonth) / $newLastMonth * 100)
            : ($newThisMonth > 0 ? 100 : 0);

        return [
            'total_users' => $totalUsers,
            'new_users_this_month' => $newThisMonth,
            'verified_users' => $verifiedUsers,
            'unverified_users' => $unverifiedUsers,
            'users_without_role' => $usersWithoutRole,
            'verification_rate' => $totalUsers > 0 ? (int) round($verifiedUsers / $totalUsers * 100) : 0,
            'growth_percentage' => $growthPercentage,
            'total_roles' => Role::where('active', true)->count(),
        ];
    }

    /**
     * @return array<int, array{name: string, users_count: int}>
     */
    public function getRoleDistribution(): array
    {
        return Role::withCount('users')
            ->where('active', true)
            ->orderByDesc('users_count')
            ->get(['id', 'name', 'display_name'])
            ->map(fn($role) => [
                'name' => $role->display_name ?? $role->name,
                'users_count' => $role->users_count,
            ])
            ->toArray();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRecentUsers(int $limit = 8): array
    {
        return User::with('role:id,name,display_name')
            ->latest()
            ->limit($limit)
            ->get(['id', 'name', 'email', 'role_id', 'email_verified_at', 'created_at'])
            ->map(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'initials' => strtoupper(mb_substr($user->name, 0, 1)),
                'role' => $user->role ? ($user->role->display_name ?? $user->role->name) : null,
                'verified' => $user->email_verified_at !== null,
                'created_at' => $user->created_at->format('d M Y'),
            ])
            ->toArray();
    }

    /**
     * @return array<int, array{month: string, count: int}>
     */
    public function getGrowthTrend(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'month' => $date->format('M Y'),
                'start' => $date->copy()->startOfMonth(),
                'end' => $date->copy()->endOfMonth(),
            ]);
        }

        return $months->map(fn($period) => [
            'month' => $period['month'],
            'count' => User::whereBetween('created_at', [$period['start'], $period['end']])->count(),
        ])->toArray();
    }
}
