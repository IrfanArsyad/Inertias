<template>
    <div>
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-1">Permissions List</h4>
                <p class="mb-0">Permissions you may use and assign to your users.</p>
            </div>
        </div>

        <!-- Permissions Table Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Permissions List</h5>
                <button @click="openCreateModal" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>
                    Add Permission
                </button>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Assigned To</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="permission in permissions" :key="permission.id">
                            <td>
                                <span class="text-nowrap">{{ permission.name }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-group">
                                        <div v-for="i in Math.min(permission.users_count || 3, 4)" :key="i"
                                             class="avatar avatar-sm">
                                            <img :src="`/assets/img/avatars/${i}.png`"
                                                 alt="Avatar"
                                                 class="rounded-circle">
                                        </div>
                                        <div v-if="(permission.users_count || 3) > 4"
                                             class="avatar avatar-sm">
                                            <span class="avatar-initial rounded-circle bg-label-secondary">
                                                +{{ (permission.users_count || 3) - 4 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ permission.created_at }}</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button"
                                            class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item"
                                           href="javascript:void(0);"
                                           @click="openEditModal(permission)">
                                            <i class="bx bx-edit me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item"
                                           href="javascript:void(0);"
                                           @click="deletePermission(permission.id)">
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

        <!-- Add/Edit Permission Modal -->
        <Modal v-model:show="showModal" :title="modalTitle" size="md">
            <form @submit.prevent="submit">
                <!-- Warning for Edit -->
                <div v-if="isEditing" class="alert alert-warning mb-3" role="alert">
                    <h6 class="alert-heading mb-1">Warning</h6>
                    <p class="mb-0">
                        By editing the permission name, you might break the system permissions functionality.
                        Please ensure you're absolutely certain before proceeding.
                    </p>
                </div>

                <!-- Permission Name -->
                <div class="mb-3">
                    <label class="form-label" for="permissionName">Permission Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        id="permissionName"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.name }"
                        placeholder="Enter a permission name"
                    />
                    <div v-if="form.errors.name" class="invalid-feedback">
                        {{ form.errors.name }}
                    </div>
                </div>

                <!-- Core Permission Checkbox -->
                <div class="mb-3">
                    <div class="form-check">
                        <input
                            v-model="form.is_core"
                            class="form-check-input"
                            type="checkbox"
                            id="corePermission"
                        />
                        <label class="form-check-label" for="corePermission">
                            Set as core permission
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <button
                        type="button"
                        class="btn btn-label-secondary"
                        @click="closeModal"
                        :disabled="form.processing"
                    >
                        {{ isEditing ? 'Discard' : 'Cancel' }}
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        :disabled="form.processing"
                    >
                        <span v-if="!form.processing">
                            {{ isEditing ? 'Update' : 'Create Permission' }}
                        </span>
                        <span v-else>
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    permissions: {
        type: Array,
        default: () => []
    }
});

const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const modalTitle = ref('Add New Permission');

const form = useForm({
    name: '',
    is_core: false
});

const openCreateModal = () => {
    isEditing.value = false;
    editingId.value = null;
    modalTitle.value = 'Add New Permission';
    form.reset();
    form.clearErrors();
    showModal.value = true;
};

const openEditModal = (permission) => {
    isEditing.value = true;
    editingId.value = permission.id;
    modalTitle.value = 'Edit Permission';
    form.name = permission.name;
    form.is_core = permission.is_core || false;
    form.clearErrors();
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
    form.clearErrors();
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('permission.update', editingId.value), {
            onSuccess: () => closeModal()
        });
    } else {
        form.post(route('permission.store'), {
            onSuccess: () => closeModal()
        });
    }
};

const deletePermission = (permissionId) => {
    if (confirm('Are you sure you want to delete this permission?')) {
        router.delete(route('permission.destroy', permissionId));
    }
};
</script>

<style scoped>
.avatar-group {
    display: flex;
}

.avatar-group .avatar {
    margin-left: -0.75rem;
}

.avatar-group .avatar:first-child {
    margin-left: 0;
}
</style>
