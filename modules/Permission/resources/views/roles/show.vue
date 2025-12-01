<template>
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Role Details</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <div class="modal-body">
                <!-- Role Info -->
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="bx bx-user-check fs-4"></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-1">{{ role.display_name || role.name }}</h5>
                        <span class="badge" :class="role.active ? 'bg-label-success' : 'bg-label-secondary'">
                            {{ role.active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge bg-label-info ms-1">{{ role.users_count }} Users</span>
                    </div>
                </div>

                <!-- Role Details Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="ps-0" style="width: 150px;">ID</th>
                                <td>{{ role.id }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Name</th>
                                <td><code>{{ role.name }}</code></td>
                            </tr>
                            <tr>
                                <th class="ps-0">Display Name</th>
                                <td>{{ role.display_name || '-' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Description</th>
                                <td>{{ role.description || '-' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Created At</th>
                                <td>{{ formatDate(role.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Permissions Table -->
                <h6 class="mb-3">Assigned Permissions</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Module</th>
                                <th class="text-center">Read</th>
                                <th class="text-center">Create</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="module in modules" :key="module.id">
                                <td>
                                    <i :class="module.icon" class="me-2"></i>
                                    {{ module.label }}
                                </td>
                                <td class="text-center">
                                    <i v-if="hasPermission('read', module.id)" class="bx bx-check text-success"></i>
                                    <i v-else class="bx bx-x text-muted"></i>
                                </td>
                                <td class="text-center">
                                    <i v-if="hasPermission('create', module.id)" class="bx bx-check text-success"></i>
                                    <i v-else class="bx bx-x text-muted"></i>
                                </td>
                                <td class="text-center">
                                    <i v-if="hasPermission('update', module.id)" class="bx bx-check text-success"></i>
                                    <i v-else class="bx bx-x text-muted"></i>
                                </td>
                                <td class="text-center">
                                    <i v-if="hasPermission('delete', module.id)" class="bx bx-check text-success"></i>
                                    <i v-else class="bx bx-x text-muted"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" @click="close">
                    Close
                </button>
                <Link
                    v-if="!isAdminRole"
                    :href="route('permission.roles.edit', role.id)"
                    class="btn btn-primary"
                    @click="close"
                >
                    <i class="bx bx-edit me-1"></i> Edit Role
                </Link>
                <button v-else class="btn btn-secondary" disabled>
                    <i class="bx bx-lock-alt me-1"></i> Protected Role
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useModal } from 'inertia-modal';

const props = defineProps({
    role: {
        type: Object,
        required: true
    },
    modules: {
        type: Array,
        required: true
    }
});

const { close } = useModal();

// Check if role is Administrator (protected)
const isAdminRole = computed(() => {
    return props.role.name?.toLowerCase() === 'administrator';
});

const hasPermission = (action, moduleId) => {
    const perms = props.role[action] || [];
    return perms.includes('*') || perms.includes(moduleId);
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>
