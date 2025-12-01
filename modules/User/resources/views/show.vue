<template>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <div class="modal-body">
                <!-- User Avatar and Basic Info -->
                <div class="text-center mb-4">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary fs-3">
                            {{ getInitials(user.name) }}
                        </span>
                    </div>
                    <h5 class="mb-1">{{ user.name }}</h5>
                    <p class="text-muted mb-2">{{ user.email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span
                            class="badge"
                            :class="user.email_verified_at ? 'bg-label-success' : 'bg-label-warning'"
                        >
                            {{ user.email_verified_at ? 'Active' : 'Inactive' }}
                        </span>
                        <span v-if="user.role" class="badge bg-label-primary">
                            {{ user.role.display_name || user.role.name }}
                        </span>
                        <span v-else class="badge bg-label-secondary">
                            No Role
                        </span>
                    </div>
                </div>

                <!-- User Details Table -->
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="ps-0" style="width: 150px;">ID</th>
                                <td>{{ user.id }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Full Name</th>
                                <td>{{ user.name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Email</th>
                                <td>{{ user.email }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Role</th>
                                <td>
                                    <span v-if="user.role" class="badge bg-label-primary">
                                        {{ user.role.display_name || user.role.name }}
                                    </span>
                                    <span v-else class="text-muted fst-italic">No role assigned</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0">Status</th>
                                <td>
                                    <span
                                        class="badge"
                                        :class="user.email_verified_at ? 'bg-label-success' : 'bg-label-warning'"
                                    >
                                        {{ user.email_verified_at ? 'Active (Verified)' : 'Inactive (Unverified)' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0">Created At</th>
                                <td>{{ formatDate(user.created_at) }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Updated At</th>
                                <td>{{ formatDate(user.updated_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" @click="close">
                    Close
                </button>
                <Link :href="route('users.edit', user.id)" class="btn btn-primary" @click="close">
                    <i class="bx bx-edit me-1"></i> Edit User
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useModal } from 'inertia-modal';

const props = defineProps({
    user: Object,
});

const { close } = useModal();

const getInitials = (name) => {
    return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
        .substring(0, 2);
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

<style scoped>
.avatar-xl {
    width: 80px;
    height: 80px;
}

.avatar-initial {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
