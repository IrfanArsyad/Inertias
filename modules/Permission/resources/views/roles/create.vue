<template>
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Role</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name">
                                Role Name <span class="text-danger">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                id="name"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.name }"
                                placeholder="e.g., admin, manager, user"
                            />
                            <div v-if="form.errors.name" class="invalid-feedback">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="display_name">Display Name</label>
                            <input
                                v-model="form.display_name"
                                type="text"
                                id="display_name"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.display_name }"
                                placeholder="e.g., Administrator"
                            />
                            <div v-if="form.errors.display_name" class="invalid-feedback">
                                {{ form.errors.display_name }}
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea
                            v-model="form.description"
                            id="description"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.description }"
                            placeholder="Role description..."
                            rows="2"
                        ></textarea>
                        <div v-if="form.errors.description" class="invalid-feedback">
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input
                            v-model="form.active"
                            type="checkbox"
                            class="form-check-input"
                            id="activeSwitch"
                        />
                        <label class="form-check-label" for="activeSwitch">
                            Active
                        </label>
                    </div>

                    <div class="mb-3">
                        <h6 class="mb-3">Assign Permissions</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Module</th>
                                        <th class="text-center">Read</th>
                                        <th class="text-center">Create</th>
                                        <th class="text-center">Update</th>
                                        <th class="text-center">Delete</th>
                                        <th class="text-center">All</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="module in modules" :key="module.id">
                                        <td>
                                            <i :class="module.icon" class="me-2"></i>
                                            {{ module.label }}
                                        </td>
                                        <td class="text-center">
                                            <input
                                                v-model="permissions[module.id].read"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                        </td>
                                        <td class="text-center">
                                            <input
                                                v-model="permissions[module.id].create"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                        </td>
                                        <td class="text-center">
                                            <input
                                                v-model="permissions[module.id].update"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                        </td>
                                        <td class="text-center">
                                            <input
                                                v-model="permissions[module.id].delete"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                        </td>
                                        <td class="text-center">
                                            <button
                                                type="button"
                                                @click="toggleAll(module.id)"
                                                class="btn btn-sm btn-link p-0"
                                            >
                                                <i class="bx bx-check-square"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" @click="close" :disabled="form.processing">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="form.processing">
                        <span v-if="form.processing">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Creating...
                        </span>
                        <span v-else>
                            <i class="bx bx-save me-1"></i> Create Role
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useModal } from 'inertia-modal';

const props = defineProps({
    modules: {
        type: Array,
        required: true
    }
});

const { close, redirect } = useModal();

const form = useForm({
    name: '',
    display_name: '',
    description: '',
    active: true,
    read: [],
    create: [],
    update: [],
    delete: []
});

// Initialize permissions object
const permissions = ref({});
props.modules.forEach(module => {
    permissions.value[module.id] = {
        read: false,
        create: false,
        update: false,
        delete: false
    };
});

const toggleAll = (moduleId) => {
    const allChecked = Object.values(permissions.value[moduleId]).every(v => v);
    const newValue = !allChecked;

    permissions.value[moduleId] = {
        read: newValue,
        create: newValue,
        update: newValue,
        delete: newValue
    };
};

const submit = () => {
    // Convert permissions object to arrays
    form.read = [];
    form.create = [];
    form.update = [];
    form.delete = [];

    Object.entries(permissions.value).forEach(([moduleId, perms]) => {
        const id = parseInt(moduleId);
        if (perms.read) form.read.push(id);
        if (perms.create) form.create.push(id);
        if (perms.update) form.update.push(id);
        if (perms.delete) form.delete.push(id);
    });

    form.post(route('permission.roles.store'), {
        onSuccess: () => redirect()
    });
};
</script>
