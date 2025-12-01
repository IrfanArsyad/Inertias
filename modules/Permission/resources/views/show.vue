<template>
    <MainLayout>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Permission Details</h5>
                        <div class="d-flex gap-2">
                            <Button 
                                :href="route('permission.edit', item.id)" 
                                variant="primary"
                                size="sm"
                            >
                                <i class="bx bx-edit me-1"></i> Edit
                            </Button>
                            <Button 
                                :href="route('permission.index')" 
                                variant="secondary"
                                size="sm"
                            >
                                <i class="bx bx-arrow-back me-1"></i> Back to List
                            </Button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">ID</label>
                                <p class="form-control-plaintext">{{ item.id }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <p class="form-control-plaintext">{{ item.name }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="form-control-plaintext">
                                    <span 
                                        class="badge"
                                        :class="{
                                            'bg-success': item.status === 'active',
                                            'bg-danger': item.status === 'inactive',
                                            'bg-warning': item.status === 'pending'
                                        }"
                                    >
                                        {{ item.status }}
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Created At</label>
                                <p class="form-control-plaintext">
                                    {{ new Date(item.created_at).toLocaleString() }}
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Updated At</label>
                                <p class="form-control-plaintext">
                                    {{ new Date(item.updated_at).toLocaleString() }}
                                </p>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <p class="form-control-plaintext">{{ item.description || '-' }}</p>
                            </div>

                            <!-- Add more fields as needed -->
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between">
                                <Button 
                                    variant="danger"
                                    @click="handleDelete"
                                    :disabled="deleting"
                                >
                                    <i class="bx bx-trash me-1"></i>
                                    Delete
                                </Button>
                                <Button 
                                    :href="route('permission.edit', item.id)" 
                                    variant="primary"
                                >
                                    <i class="bx bx-edit me-1"></i>
                                    Edit Permission
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const deleting = ref(false);

const handleDelete = () => {
    if (!confirm('Are you sure you want to delete this item?')) {
        return;
    }

    deleting.value = true;
    router.delete(route('permission.destroy', props.item.id), {
        preserveScroll: true,
        onFinish: () => {
            deleting.value = false;
        }
    });
};
</script>
