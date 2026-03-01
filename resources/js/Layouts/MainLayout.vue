<template>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu / Sidebar -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <!-- App Brand -->
                <div class="app-brand demo">
                    <Link href="/" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">{{ appName }}</span>
                    </Link>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <!-- Menu Inner -->
                <ul class="menu-inner py-1">
                    <!-- Dynamic Menu Items from Modules -->
                    <template v-for="(item, index) in menuItems" :key="index">
                        <!-- Section Header -->
                        <li v-if="item.type === 'header'" class="menu-header small text-uppercase">
                            <span class="menu-header-text">{{ item.label }}</span>
                        </li>

                        <!-- Menu Item with Submenu -->
                        <li v-else-if="item.children" class="menu-item" :class="{ 'open': isMenuOpen(item) }">
                            <a href="javascript:void(0);" class="menu-link menu-toggle" @click="toggleSubmenu(item, $event)">
                                <i class="menu-icon tf-icons" :class="item.icon"></i>
                                <div>{{ item.label }}</div>
                            </a>
                            <ul class="menu-sub">
                                <li v-for="(child, childIndex) in item.children" :key="childIndex"
                                    class="menu-item" :class="{ active: isActive(child.route) }">
                                    <Link :href="child.route" class="menu-link">
                                        <div>{{ child.label }}</div>
                                    </Link>
                                </li>
                            </ul>
                        </li>

                        <!-- Single Menu Item -->
                        <li v-else class="menu-item" :class="{ active: isActive(item.route) }">
                            <Link :href="item.route" class="menu-link">
                                <i class="menu-icon tf-icons" :class="item.icon"></i>
                                <div>{{ item.label }}</div>
                            </Link>
                        </li>
                    </template>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    <i class="bx bx-search bx-sm"></i>
                                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Language -->
                            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class='bx bx-globe bx-sm'></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <span class="align-middle">English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <span class="align-middle">Indonesia</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ Language -->

                            <!-- Theme Toggle -->
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class='bx bx-sm' :class="themeIcon"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" @click="setTheme('light')" :class="{ active: currentTheme === 'light' }">
                                            <span class="align-middle"><i class='bx bx-sun me-2'></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" @click="setTheme('dark')" :class="{ active: currentTheme === 'dark' }">
                                            <span class="align-middle"><i class='bx bx-moon me-2'></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" @click="setTheme('system')" :class="{ active: currentTheme === 'system' }">
                                            <span class="align-middle"><i class='bx bx-desktop me-2'></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ Theme Toggle -->

                            <!-- Notification -->
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="bx bx-bell bx-sm"></i>
                                    <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                                </a>
                                <!-- Dropdown content here -->
                            </li>
                            <!--/ Notification -->

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img :src="$page.props.auth.user?.avatar || '/assets/img/avatars/1.png'" alt class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img :src="$page.props.auth.user?.avatar || '/assets/img/avatars/1.png'" alt class="w-px-40 h-auto rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block">{{ $page.props.auth.user?.name }}</span>
                                                    <small class="text-muted">{{ $page.props.auth.user?.email }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <Link href="/profile" class="dropdown-item">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href="/settings" class="dropdown-item">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </Link>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a href="#" @click.prevent="logout" class="dropdown-item">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
                        <input type="text" class="form-control search-input border-0" placeholder="Search..." aria-label="Search...">
                        <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Flash Messages -->
                        <Alert
                            v-if="$page.props.flash.success"
                            type="success"
                            :message="$page.props.flash.success"
                            dismissible
                            auto-dismiss
                            :auto-dismiss-delay="5000"
                        />
                        <Alert
                            v-if="$page.props.flash.error"
                            type="danger"
                            :message="$page.props.flash.error"
                            dismissible
                            auto-dismiss
                            :auto-dismiss-delay="8000"
                        />
                        <Alert
                            v-if="$page.props.flash.warning"
                            type="warning"
                            :message="$page.props.flash.warning"
                            dismissible
                            auto-dismiss
                            :auto-dismiss-delay="5000"
                        />
                        <Alert
                            v-if="$page.props.flash.info"
                            type="info"
                            :message="$page.props.flash.info"
                            dismissible
                            auto-dismiss
                            :auto-dismiss-delay="5000"
                        />

                        <!-- Page Content -->
                        <slot />

                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                &copy; {{ new Date().getFullYear() }}, made with ❤️ by
                                <a href="https://pixinvent.com" target="_blank" class="footer-link fw-medium">Pixinvent</a>
                            </div>
                            <div class="d-none d-lg-inline-block">
                                <a href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
                                <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link me-4">Support</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Inertia Modal - untuk modal routing -->
    <InertiaModalWrapper :show="modalShow" @close="modalClose">
        <InertiaModal />
    </InertiaModalWrapper>
</template>

<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import Alert from '@/Components/Alert.vue';
import { Modal as InertiaModal, useModal } from 'inertia-modal';
import InertiaModalWrapper from '@/Components/InertiaModalWrapper.vue';

// Inertia Modal state
const { show: modalShow, close: modalClose } = useModal();

const props = defineProps({
    appName: {
        type: String,
        default: 'Materialize'
    }
});

// Access menuItems from global shared props
const menuItems = computed(() => usePage().props.menuItems || []);

// Track manually toggled menus (can be opened or closed)
const manuallyToggledMenus = ref(new Map()); // Map<label, boolean>

// Theme management
const currentTheme = ref('light');

const themeIcon = computed(() => {
    switch (currentTheme.value) {
        case 'dark':
            return 'bx-moon';
        case 'system':
            return 'bx-desktop';
        default:
            return 'bx-sun';
    }
});

const setTheme = (theme) => {
    currentTheme.value = theme;
    localStorage.setItem('theme', theme);

    const htmlRoot = document.getElementById('html-root');
    if (!htmlRoot) return;

    let isDark = false;

    if (theme === 'system') {
        // Use system preference
        isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    } else if (theme === 'dark') {
        isDark = true;
    }

    // Remove all theme classes
    htmlRoot.classList.remove('light-style', 'dark-style');
    htmlRoot.classList.add(isDark ? 'dark-style' : 'light-style');
    htmlRoot.setAttribute('data-theme', isDark ? 'theme-dark' : 'theme-default');

    // Update CSS files
    const coreLink = document.querySelector('.template-customizer-core-css');
    const themeLink = document.querySelector('.template-customizer-theme-css');

    if (coreLink) {
        coreLink.href = isDark
            ? '/assets/vendor/css/rtl/core-dark.css'
            : '/assets/vendor/css/rtl/core.css';
    }

    if (themeLink) {
        themeLink.href = isDark
            ? '/assets/vendor/css/rtl/theme-default-dark.css'
            : '/assets/vendor/css/rtl/theme-default.css';
    }
};

const isActive = (route) => {
    return window.location.pathname === route;
};

const isMenuOpen = (item) => {
    if (!item.children) return false;

    // Check if user has manually toggled this menu
    if (manuallyToggledMenus.value.has(item.label)) {
        return manuallyToggledMenus.value.get(item.label);
    }

    // Default: open if has active child
    return item.children.some(child => isActive(child.route));
};

const toggleSubmenu = (item, event) => {
    event.preventDefault();
    const currentState = isMenuOpen(item);
    manuallyToggledMenus.value.set(item.label, !currentState);
    // Trigger reactivity
    manuallyToggledMenus.value = new Map(manuallyToggledMenus.value);
};

const logout = () => {
    router.post('/logout');
};

onMounted(() => {
    // Initialize theme from localStorage
    const savedTheme = localStorage.getItem('theme') || 'light';
    currentTheme.value = savedTheme;
    setTheme(savedTheme);

    // Listen for system theme changes if system theme is selected
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', (e) => {
        if (currentTheme.value === 'system') {
            setTheme('system');
        }
    });
});
</script>
