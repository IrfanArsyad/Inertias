<template>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                id="name"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.name }"
                                placeholder="Enter full name"
                            />
                            <div v-if="form.errors.name" class="invalid-feedback">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                id="email"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.email }"
                                placeholder="Enter email address"
                            />
                            <div v-if="form.errors.email" class="invalid-feedback">
                                {{ form.errors.email }}
                            </div>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label" for="role">Role</label>
                        <select
                            v-model="form.role_id"
                            id="role"
                            class="form-select"
                            :class="{ 'is-invalid': form.errors.role_id }"
                        >
                            <option :value="null">Select a role</option>
                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                {{ role.display_name || role.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.role_id" class="invalid-feedback">
                            {{ form.errors.role_id }}
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="border rounded p-3 mb-3">
                        <h6 class="mb-3">Change Password</h6>
                        <p class="text-muted small mb-3">
                            Leave blank to keep current password
                        </p>

                        <div class="row">
                            <!-- New Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        v-model="form.password"
                                        :type="showPassword ? 'text' : 'password'"
                                        id="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.password }"
                                        placeholder="Enter new password"
                                    />
                                    <span
                                        class="input-group-text cursor-pointer"
                                        @click="showPassword = !showPassword"
                                    >
                                        <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"></i>
                                    </span>
                                    <div v-if="form.errors.password" class="invalid-feedback">
                                        {{ form.errors.password }}
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-0">
                                <label class="form-label" for="password_confirmation">
                                    Confirm New Password
                                </label>
                                <div class="input-group input-group-merge">
                                    <input
                                        v-model="form.password_confirmation"
                                        :type="showConfirmPassword ? 'text' : 'password'"
                                        id="password_confirmation"
                                        class="form-control"
                                        placeholder="Confirm new password"
                                    />
                                    <span
                                        class="input-group-text cursor-pointer"
                                        @click="showConfirmPassword = !showConfirmPassword"
                                    >
                                        <i :class="showConfirmPassword ? 'bx bx-show' : 'bx bx-hide'"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Verified -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input
                                v-model="form.email_verified"
                                type="checkbox"
                                id="email_verified"
                                class="form-check-input"
                            />
                            <label class="form-check-label" for="email_verified">
                                Email Verified (Active)
                            </label>
                        </div>
                        <small class="text-muted">
                            Toggle to activate or deactivate user access
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" @click="close" :disabled="form.processing">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="form.processing">
                        <span v-if="form.processing">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Saving...
                        </span>
                        <span v-else>
                            <i class="bx bx-save me-1"></i> Save Changes
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
    user: Object,
    roles: Array,
});

const { close, redirect } = useModal();

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role_id: props.user.role_id,
    email_verified: props.user.email_verified,
});

const submit = () => {
    form.put(route('users.update', props.user.id), {
        onSuccess: () => redirect(),
    });
};
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
