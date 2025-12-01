<template>
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change User Role</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="avatar avatar-lg mx-auto mb-2">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                {{ getInitials(user.name) }}
                            </span>
                        </div>
                        <h6 class="mb-0">{{ user.name }}</h6>
                        <small class="text-muted">{{ user.email }}</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Role</label>
                        <select
                            v-model="form.role_id"
                            class="form-select"
                            :class="{ 'is-invalid': form.errors.role_id }"
                        >
                            <option :value="null">No Role</option>
                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                {{ role.display_name || role.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.role_id" class="invalid-feedback">
                            {{ form.errors.role_id }}
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
                            <i class="bx bx-check me-1"></i> Update Role
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
    user: {
        type: Object,
        required: true
    },
    roles: {
        type: Array,
        required: true
    }
});

const { close, redirect } = useModal();

const form = useForm({
    role_id: props.user.role_id
});

const getInitials = (name) => {
    return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
        .substring(0, 2);
};

const submit = () => {
    form.patch(route('users.update-role', props.user.id), {
        onSuccess: () => redirect()
    });
};
</script>

<style scoped>
.avatar-lg {
    width: 60px;
    height: 60px;
}

.avatar-initial {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}
</style>
