<template>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0"/>
                                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616"/>
                                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0"/>
                                    </svg>
                                </span>
                                <span class="app-brand-text demo text-body fw-bold">{{ appName }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-2">Welcome to {{ appName }}! 👋</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>

                        <!-- Alert Messages -->
                        <Alert
                            v-if="$page.props.flash.error"
                            type="danger"
                            :message="$page.props.flash.error"
                            dismissible
                        />

                        <Alert
                            v-if="$page.props.flash.success"
                            type="success"
                            :message="$page.props.flash.success"
                            dismissible
                        />

                        <!-- Login Form -->
                        <form @submit.prevent="submit" class="mb-3">
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input
                                    v-model="form.email"
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email or username"
                                    :class="{ 'is-invalid': form.errors.email }"
                                    autofocus
                                />
                                <div v-if="form.errors.email" class="invalid-feedback">
                                    {{ form.errors.email }}
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="javascript:void(0);">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        v-model="form.password"
                                        :type="showPassword ? 'text' : 'password'"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        :class="{ 'is-invalid': form.errors.password }"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password"
                                    />
                                    <span class="input-group-text cursor-pointer" @click="showPassword = !showPassword">
                                        <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"></i>
                                    </span>
                                </div>
                                <div v-if="form.errors.password" class="text-danger mt-1">
                                    <small>{{ form.errors.password }}</small>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input
                                        v-model="form.remember"
                                        class="form-check-input"
                                        type="checkbox"
                                        id="remember-me"
                                    />
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button
                                    type="submit"
                                    class="btn btn-primary d-grid w-100"
                                    :disabled="form.processing"
                                >
                                    <span v-if="!form.processing">Sign in</span>
                                    <span v-else>
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Signing in...
                                    </span>
                                </button>
                            </div>
                        </form>

                        <!-- Register Link -->
                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="javascript:void(0);">
                                <span>Create an account</span>
                            </a>
                        </p>

                        <!-- Demo Credentials -->
                        <div class="divider my-4">
                            <div class="divider-text">Demo Credentials</div>
                        </div>

                        <div class="alert alert-primary">
                            <h6 class="alert-heading mb-2">Test Account</h6>
                            <div class="d-flex flex-column">
                                <small><strong>Email:</strong> admin@example.com</small>
                                <small><strong>Password:</strong> password</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Login Card -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';

defineProps({
    appName: {
        type: String,
        default: 'Materialize'
    }
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>
