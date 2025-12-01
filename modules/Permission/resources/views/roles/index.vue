<template>
    <div>
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-1">Roles List</h4>
                <p class="mb-0">A role provided access to predefined menus and features so that depending on assigned role an administrator can have access to what he need</p>
            </div>
        </div>

        <!-- Role Cards -->
        <div class="row g-4 mb-4">
            <div v-for="role in roles" :key="role.id" class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Total {{ role.users_count || 0 }} users</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                <li v-for="i in Math.min(role.users_count || 3, 4)" :key="i"
                                    data-bs-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-bs-placement="top"
                                    :title="`User ${i}`"
                                    class="avatar avatar-sm pull-up">
                                    <img class="rounded-circle" :src="`/assets/img/avatars/${i}.png`" alt="Avatar">
                                </li>
                                <li v-if="(role.users_count || 3) > 4" class="avatar avatar-sm">
                                    <span class="avatar-initial rounded-circle pull-up bg-lighter text-body">
                                        +{{ (role.users_count || 3) - 4 }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="role-heading">
                                <h5 class="mb-1">{{ role.display_name || role.name }}</h5>
                                <Link
                                    v-if="!isAdminRole(role)"
                                    :href="route('permission.roles.edit', role.id)"
                                    class="role-edit-modal"
                                >
                                    <span>Edit Role</span>
                                </Link>
                                <span v-else class="text-muted small">
                                    <i class="bx bx-lock-alt me-1"></i>System Role
                                </span>
                            </div>
                            <Link :href="route('permission.roles.show', role.id)" class="text-muted">
                                <i class="bx bx-show"></i>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add New Role Card -->
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="/assets/img/illustrations/girl-with-laptop-light.png"
                                     class="img-fluid"
                                     alt="Image"
                                     width="120"
                                     style="max-width: 100%;">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <Link :href="route('permission.roles.create')" class="btn btn-primary mb-2 text-nowrap">
                                    Add New Role
                                </Link>
                                <p class="mb-0">Add role, if it doesn't exist.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total users with their roles table -->
        <div class="card">
            <h5 class="card-header">Total users with their roles</h5>
            <div class="card-datatable table-responsive">
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in sampleUsers" :key="user.id">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <img :src="user.avatar" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-sm">{{ user.name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ user.email }}</td>
                            <td>
                                <span class="badge bg-label-primary">{{ user.role }}</span>
                            </td>
                            <td>{{ user.plan }}</td>
                            <td>
                                <span class="badge" :class="{
                                    'bg-label-success': user.status === 'Active',
                                    'bg-label-warning': user.status === 'Pending',
                                    'bg-label-danger': user.status === 'Inactive'
                                }">{{ user.status }}</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button"
                                            class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-show me-1"></i> View
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-edit me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    roles: {
        type: Array,
        default: () => []
    },
    modules: {
        type: Array,
        default: () => []
    }
});

// Check if role is Administrator (protected)
const isAdminRole = (role) => {
    return role.name?.toLowerCase() === 'administrator';
};

// Sample users data
const sampleUsers = [
    { id: 1, name: 'Galen Slixby', email: 'gslixby0@abc.net.au', avatar: '/assets/img/avatars/1.png', role: 'Editor', plan: 'Enterprise', status: 'Active' },
    { id: 2, name: 'Halsey Redmore', email: 'hredmore1@imgur.com', avatar: '/assets/img/avatars/2.png', role: 'Author', plan: 'Team', status: 'Pending' },
    { id: 3, name: 'Marjory Sicely', email: 'msicely2@who.int', avatar: '/assets/img/avatars/3.png', role: 'Maintainer', plan: 'Enterprise', status: 'Active' },
];
</script>

<style scoped>
.avatar-group {
    display: flex;
}

.pull-up {
    transition: transform 0.25s ease;
}

.pull-up:hover {
    transform: translateY(-4px);
    z-index: 2;
}

.role-edit-modal {
    color: #696cff;
    text-decoration: none;
}

.role-edit-modal:hover {
    color: #5f52ff;
}
</style>
