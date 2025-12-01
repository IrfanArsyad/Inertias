<template>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Test Item</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="name">
                            Name <span class="text-danger">*</span>
                        </label>
                        <input
                            v-model="form.name"
                            type="text"
                            id="name"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.name }"
                            placeholder="Enter test item name"
                        />
                        <div v-if="form.errors.name" class="invalid-feedback">
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea
                            v-model="form.description"
                            id="description"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.description }"
                            placeholder="Enter description"
                            rows="3"
                        ></textarea>
                        <div v-if="form.errors.description" class="invalid-feedback">
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select
                            v-model="form.status"
                            id="status"
                            class="form-select"
                            :class="{ 'is-invalid': form.errors.status }"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div v-if="form.errors.status" class="invalid-feedback">
                            {{ form.errors.status }}
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
                            Updating...
                        </span>
                        <span v-else>
                            <i class="bx bx-save me-1"></i> Update
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { useModal } from 'inertia-modal';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const { close, redirect } = useModal();

const form = useForm({
    name: props.item.name,
    description: props.item.description,
    status: props.item.status
});

const submit = () => {
    form.put(route('test.update', props.item.id), {
        onSuccess: () => redirect()
    });
};
</script>
