<template>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Item Details</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="ps-0" style="width: 120px;">ID</th>
                                <td>{{ item.id }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Name</th>
                                <td>{{ item.name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Description</th>
                                <td>{{ item.description || '-' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Status</th>
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
                            </tr>
                            <tr>
                                <th class="ps-0">Created At</th>
                                <td>{{ formatDate(item.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" @click="close">
                    Close
                </button>
                <Link :href="route('test.edit', item.id)" class="btn btn-primary" @click="close">
                    <i class="bx bx-edit me-1"></i> Edit
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useModal } from 'inertia-modal';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const { close } = useModal();

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>
