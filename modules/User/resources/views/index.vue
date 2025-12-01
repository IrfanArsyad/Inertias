<template>
    <div>
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Users</h4>
                <p class="text-muted mb-0">Manage system users, their roles and access permissions</p>
            </div>
            <Link :href="route('users.create')" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add User
            </Link>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input
                            v-model="filterForm.search"
                            type="text"
                            class="form-control"
                            placeholder="Search by name or email..."
                            @input="debouncedFilter"
                        />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Role</label>
                        <select v-model="filterForm.role_id" class="form-select" @change="applyFilters">
                            <option value="">All Roles</option>
                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                {{ role.display_name || role.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select v-model="filterForm.status" class="form-select" @change="applyFilters">
                            <option value="">All Status</option>
                            <option value="active">Active (Verified)</option>
                            <option value="inactive">Inactive (Unverified)</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-secondary w-100" @click="resetFilters">
                            <i class="bx bx-reset me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Users List</h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted">{{ users.total }} users</span>
                    <select v-model="filterForm.per_page" class="form-select form-select-sm" style="width: auto;" @change="applyFilters">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    v-model="selectAll"
                                    @change="toggleSelectAll"
                                />
                            </th>
                            <th class="cursor-pointer" @click="sortBy('name')">
                                User
                                <i v-if="filterForm.sort === 'name'" :class="sortIcon"></i>
                            </th>
                            <th class="cursor-pointer" @click="sortBy('email')">
                                Email
                                <i v-if="filterForm.sort === 'email'" :class="sortIcon"></i>
                            </th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="cursor-pointer" @click="sortBy('created_at')">
                                Created
                                <i v-if="filterForm.sort === 'created_at'" :class="sortIcon"></i>
                            </th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    v-model="selectedIds"
                                    :value="user.id"
                                    :disabled="isAdminUser(user)"
                                    :title="isAdminUser(user) ? 'Administrator users cannot be deleted' : ''"
                                />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ getInitials(user.name) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ user.name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ user.email }}</td>
                            <td>
                                <span v-if="user.role" class="badge bg-label-primary">
                                    {{ user.role.display_name || user.role.name }}
                                </span>
                                <span v-else class="badge bg-label-secondary">No Role</span>
                            </td>
                            <td>
                                <span
                                    class="badge cursor-pointer"
                                    :class="user.email_verified_at ? 'bg-label-success' : 'bg-label-warning'"
                                    @click="toggleVerification(user)"
                                    :title="user.email_verified_at ? 'Click to unverify' : 'Click to verify'"
                                >
                                    {{ user.email_verified_at ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ formatDate(user.created_at) }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"
                                    >
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <Link :href="route('users.show', user.id)" class="dropdown-item">
                                                <i class="bx bx-show me-1"></i> View
                                            </Link>
                                        </li>
                                        <li>
                                            <Link :href="route('users.edit', user.id)" class="dropdown-item">
                                                <i class="bx bx-edit me-1"></i> Edit
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('users.change-role', user.id)"
                                                class="dropdown-item"
                                            >
                                                <i class="bx bx-user-check me-1"></i> Change Role
                                            </Link>
                                        </li>
                                        <template v-if="!isAdminUser(user)">
                                            <li><hr class="dropdown-divider" /></li>
                                            <li>
                                                <a
                                                    href="javascript:void(0);"
                                                    class="dropdown-item text-danger"
                                                    @click="confirmDelete(user)"
                                                >
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </a>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="users.data.length === 0">
                            <td colspan="7" class="text-center py-4 text-muted">
                                No users found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Bulk Actions -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <button
                        v-if="selectedIds.length > 0"
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="confirmBulkDelete"
                    >
                        <i class="bx bx-trash me-1"></i> Delete Selected ({{ selectedIds.length }})
                    </button>
                </div>
                <Pagination :links="users.links" />
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <Modal
            v-model:show="showDeleteModal"
            title="Confirm Delete"
            size="sm"
            centered
            :show-footer="true"
            confirm-text="Delete"
            confirm-variant="danger"
            :confirm-disabled="deleteForm.processing"
            @confirm="deleteUser"
            @cancel="showDeleteModal = false"
        >
            <p class="mb-0">
                Are you sure you want to delete <strong>{{ userToDelete?.name }}</strong>?
                This action cannot be undone.
            </p>
        </Modal>

        <!-- Bulk Delete Confirmation Modal -->
        <Modal
            v-model:show="showBulkDeleteModal"
            title="Confirm Bulk Delete"
            size="sm"
            centered
            :show-footer="true"
            confirm-text="Delete All"
            confirm-variant="danger"
            :confirm-disabled="bulkDeleteForm.processing"
            @confirm="bulkDelete"
            @cancel="showBulkDeleteModal = false"
        >
            <p class="mb-0">
                Are you sure you want to delete <strong>{{ selectedIds.length }}</strong> selected users?
                This action cannot be undone.
            </p>
        </Modal>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    users: Object,
    roles: Array,
    filters: Object,
});

// Filter form
const filterForm = ref({
    search: props.filters?.search || '',
    role_id: props.filters?.role_id || '',
    status: props.filters?.status || '',
    sort: props.filters?.sort || 'created_at',
    direction: props.filters?.direction || 'desc',
    per_page: props.filters?.per_page || 10,
});

// Selection
const selectedIds = ref([]);
const selectAll = ref(false);

// Modals
const showDeleteModal = ref(false);
const showBulkDeleteModal = ref(false);
const userToDelete = ref(null);

// Forms
const deleteForm = useForm({});
const bulkDeleteForm = useForm({
    ids: [],
});

// Computed
const sortIcon = computed(() => {
    return filterForm.value.direction === 'asc' ? 'bx bx-sort-up' : 'bx bx-sort-down';
});

// Check if user has Administrator role (protected from deletion)
const isAdminUser = (user) => {
    return user.role?.name?.toLowerCase() === 'administrator';
};

// Methods
const applyFilters = () => {
    router.get(route('users.index'), filterForm.value, {
        preserveState: true,
        preserveScroll: true,
    });
};

const debouncedFilter = debounce(applyFilters, 300);

const resetFilters = () => {
    filterForm.value = {
        search: '',
        role_id: '',
        status: '',
        sort: 'created_at',
        direction: 'desc',
        per_page: 10,
    };
    applyFilters();
};

const sortBy = (field) => {
    if (filterForm.value.sort === field) {
        filterForm.value.direction = filterForm.value.direction === 'asc' ? 'desc' : 'asc';
    } else {
        filterForm.value.sort = field;
        filterForm.value.direction = 'asc';
    }
    applyFilters();
};

const toggleSelectAll = () => {
    if (selectAll.value) {
        // Exclude admin users from selection
        selectedIds.value = props.users.data
            .filter(u => !isAdminUser(u))
            .map(u => u.id);
    } else {
        selectedIds.value = [];
    }
};

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
    });
};

const toggleVerification = (user) => {
    router.patch(route('users.toggle-verification', user.id), {}, {
        preserveScroll: true,
    });
};

// Delete
const confirmDelete = (user) => {
    userToDelete.value = user;
    showDeleteModal.value = true;
};

const deleteUser = () => {
    deleteForm.delete(route('users.destroy', userToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            userToDelete.value = null;
        },
    });
};

const confirmBulkDelete = () => {
    showBulkDeleteModal.value = true;
};

const bulkDelete = () => {
    bulkDeleteForm.ids = selectedIds.value;
    bulkDeleteForm.delete(route('users.bulk-destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            showBulkDeleteModal.value = false;
            selectedIds.value = [];
            selectAll.value = false;
        },
    });
};

// Watch for changes in selection
watch(selectedIds, (newVal) => {
    selectAll.value = newVal.length === props.users.data.length && newVal.length > 0;
});
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}

.table th {
    font-weight: 600;
    white-space: nowrap;
}

.avatar-initial {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}
</style>
