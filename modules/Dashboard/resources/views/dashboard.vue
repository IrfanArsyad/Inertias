<template>
    <!-- Row 1: Welcome Banner + Mini Stat Cards -->
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-xl-5 col-md-12 mb-4">
            <div class="card h-100" style="background: linear-gradient(135deg, #696cff 0%, #8592ff 100%);">
                <div class="card-body text-white d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="text-white mb-1">Welcome back, {{ userName }}! 🎉</h4>
                        <p class="mb-2 text-white-50">
                            You have <strong class="text-white">{{ stats.total_users }}</strong> total users in the system.
                        </p>
                        <Link href="/users" class="btn btn-sm btn-light">
                            View Users
                        </Link>
                    </div>
                    <div class="d-none d-sm-block">
                        <div class="avatar avatar-xl rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold" style="font-size: 2rem;">{{ userInitials }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Stat Cards -->
        <div class="col-xl-7 col-md-12 mb-4">
            <div class="row h-100">
                <div class="col-sm-4 mb-4 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="badge rounded-pill bg-label-success p-2 mb-2">
                                <i class="mdi mdi-check-decagram-outline mdi-24px"></i>
                            </span>
                            <h4 class="mb-0">{{ stats.verified_users }}</h4>
                            <small class="text-muted">Verified</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mb-4 mb-xl-0">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="badge rounded-pill bg-label-warning p-2 mb-2">
                                <i class="mdi mdi-alert-circle-outline mdi-24px"></i>
                            </span>
                            <h4 class="mb-0">{{ stats.unverified_users }}</h4>
                            <small class="text-muted">Unverified</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                            <span class="badge rounded-pill bg-label-danger p-2 mb-2">
                                <i class="mdi mdi-account-off-outline mdi-24px"></i>
                            </span>
                            <h4 class="mb-0">{{ stats.users_without_role }}</h4>
                            <small class="text-muted">No Role</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-4">
            <StatisticsCard
                subtitle="Total Users"
                :value="stats.total_users"
                icon="mdi mdi-account-group-outline mdi-24px"
                variant="primary"
            />
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <StatisticsCard
                subtitle="New This Month"
                :value="stats.new_users_this_month"
                icon="mdi mdi-account-plus-outline mdi-24px"
                variant="success"
                :trend="growthTrendLabel"
            />
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <StatisticsCard
                subtitle="Verified Rate"
                :value="stats.verification_rate + '%'"
                icon="mdi mdi-shield-check-outline mdi-24px"
                variant="info"
                :format-number="false"
            />
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <StatisticsCard
                subtitle="Active Roles"
                :value="stats.total_roles"
                icon="mdi mdi-key-outline mdi-24px"
                variant="warning"
            />
        </div>
    </div>

    <!-- Row 3: Charts -->
    <div class="row">
        <!-- Role Distribution -->
        <div class="col-md-6 col-xl-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Role Distribution</h5>
                </div>
                <div class="card-body">
                    <ApexChart
                        v-if="roleDistribution.length > 0"
                        type="donut"
                        :chart-options="donutOptions"
                        :series="donutSeries"
                        :height="300"
                    />
                    <div v-else class="text-center py-5 text-muted">
                        <i class="mdi mdi-chart-arc mdi-48px d-block mb-2"></i>
                        <p class="mb-0">No role data available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Growth (Bar Chart) -->
        <div class="col-md-6 col-xl-7 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Growth (Last 6 Months)</h5>
                </div>
                <div class="card-body">
                    <ApexChart
                        type="bar"
                        :chart-options="barOptions"
                        :series="barSeries"
                        :height="300"
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Recent Users Table -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Users</h5>
                    <Link href="/users" class="btn btn-sm btn-outline-primary">
                        View All <i class="mdi mdi-arrow-right ms-1"></i>
                    </Link>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="recentUsers.length === 0">
                                <td colspan="4" class="text-center py-4 text-muted">No users found</td>
                            </tr>
                            <tr v-for="(user, index) in recentUsers" :key="user.id">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar avatar-sm rounded-circle d-flex align-items-center justify-content-center me-2"
                                            :class="avatarColorClass(index)"
                                            style="width: 38px; height: 38px; min-width: 38px;"
                                        >
                                            <span class="fw-semibold" style="font-size: 0.875rem;">{{ user.initials }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-semibold d-block">{{ user.name }}</span>
                                            <small class="text-muted">{{ user.email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span v-if="user.role" class="badge bg-label-primary">{{ user.role }}</span>
                                    <span v-else class="text-muted">—</span>
                                </td>
                                <td>
                                    <span
                                        class="badge"
                                        :class="user.verified ? 'bg-label-success' : 'bg-label-warning'"
                                    >
                                        {{ user.verified ? 'Verified' : 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ user.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import StatisticsCard from '@/Components/StatisticsCard.vue';
import ApexChart from '@/Components/ApexChart.vue';

const props = defineProps({
    userName: {
        type: String,
        default: 'User',
    },
    stats: {
        type: Object,
        default: () => ({
            total_users: 0,
            new_users_this_month: 0,
            verified_users: 0,
            unverified_users: 0,
            users_without_role: 0,
            verification_rate: 0,
            growth_percentage: 0,
            total_roles: 0,
        }),
    },
    roleDistribution: {
        type: Array,
        default: () => [],
    },
    recentUsers: {
        type: Array,
        default: () => [],
    },
    growthTrend: {
        type: Array,
        default: () => [],
    },
});

// User initials from userName
const userInitials = computed(() => {
    const parts = props.userName.trim().split(/\s+/);
    if (parts.length >= 2) {
        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    }
    return props.userName.substring(0, 2).toUpperCase();
});

// Growth trend label for stat card
const growthTrendLabel = computed(() => {
    const pct = props.stats.growth_percentage;
    if (pct > 0) return `+${pct}%`;
    if (pct < 0) return `${pct}%`;
    return null;
});

// Avatar color rotation for recent users table
const avatarColors = ['bg-label-primary', 'bg-label-success', 'bg-label-info', 'bg-label-warning', 'bg-label-danger'];
const avatarColorClass = (index) => avatarColors[index % avatarColors.length];

// Donut chart for role distribution
const donutSeries = computed(() => props.roleDistribution.map(r => r.users_count));
const donutOptions = computed(() => ({
    labels: props.roleDistribution.map(r => r.name),
    colors: ['#696cff', '#71dd37', '#03c3ec', '#ffab00', '#ff3e1d', '#8592a3'],
    legend: {
        position: 'bottom',
    },
    plotOptions: {
        pie: {
            donut: {
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total Users',
                    },
                },
            },
        },
    },
    dataLabels: {
        enabled: false,
    },
}));

// Bar chart for growth trend
const barSeries = computed(() => ([
    {
        name: 'New Users',
        data: props.growthTrend.map(g => g.count),
    },
]));
const barOptions = computed(() => ({
    chart: {
        toolbar: { show: false },
    },
    xaxis: {
        categories: props.growthTrend.map(g => g.month),
    },
    colors: ['#696cff'],
    plotOptions: {
        bar: {
            borderRadius: 6,
            columnWidth: '45%',
            distributed: true,
        },
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.3,
            opacityFrom: 1,
            opacityTo: 0.8,
        },
    },
    legend: {
        show: false,
    },
    dataLabels: {
        enabled: false,
    },
    grid: {
        borderColor: '#f1f1f1',
    },
}));
</script>
