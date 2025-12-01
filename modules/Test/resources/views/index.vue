<template>
    <div>
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Test Module</h4>
                <p class="text-muted mb-0">Manage test items</p>
            </div>
            <Link :href="route('test.create')" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Create Test
            </Link>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Test Items</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in tests" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.description }}</td>
                            <td>
                                <span
                                    class="badge"
                                    :class="{
                                        'bg-label-success': item.status === 'active',
                                        'bg-label-secondary': item.status === 'inactive'
                                    }"
                                >
                                    {{ item.status }}
                                </span>
                            </td>
                            <td>{{ formatDate(item.created_at) }}</td>
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
                                            <Link :href="route('test.show', item.id)" class="dropdown-item">
                                                <i class="bx bx-show me-1"></i> View
                                            </Link>
                                        </li>
                                        <li>
                                            <Link :href="route('test.edit', item.id)" class="dropdown-item">
                                                <i class="bx bx-edit me-1"></i> Edit
                                            </Link>
                                        </li>
                                        <li><hr class="dropdown-divider" /></li>
                                        <li>
                                            <a
                                                href="javascript:void(0);"
                                                class="dropdown-item text-danger"
                                                @click="confirmDelete(item)"
                                            >
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="tests.length === 0">
                            <td colspan="6" class="text-center py-4 text-muted">
                                No test items found
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            @confirm="deleteItem"
            @cancel="showDeleteModal = false"
        >
            <p class="mb-0">
                Are you sure you want to delete this item?
                This action cannot be undone.
            </p>
        </Modal>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    tests: {
        type: Array,
        default: () => []
    }
});

const showDeleteModal = ref(false);
const itemToDelete = ref(null);
const deleteForm = useForm({});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const confirmDelete = (item) => {
    itemToDelete.value = item;
    showDeleteModal.value = true;
};

const deleteItem = () => {
    deleteForm.delete(route('test.destroy', itemToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            itemToDelete.value = null;
        }
    });
};
</script>
