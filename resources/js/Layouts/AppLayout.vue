<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <Link :href="route('dashboard')" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-opacity="0.4" d="M12.5 13.75C13.1904 13.75 13.75 13.1904 13.75 12.5C13.75 11.8096 13.1904 11.25 12.5 11.25C11.8096 11.25 11.25 11.8096 11.25 12.5C11.25 13.1904 11.8096 13.75 12.5 13.75Z" fill="currentColor"/>
                                <path d="M11.5833 8.25L7.66667 12.1667C7.66667 12.1667 6.91667 13 8 13H12.5C13.5833 13 13.5833 14 13.5833 14L13.6667 18.3333C13.6667 18.3333 13.75 19.25 14.5 18.4167L18.3333 14.5833C18.3333 14.5833 19.0833 13.75 18 13.75H13.5C12.4167 13.75 12.4167 12.75 12.4167 12.75L12.3333 8.41667C12.3333 8.41667 12.25 7.5 11.5833 8.25Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold">{{ $page.props.app.name }}</span>
                    </Link>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item" :class="{ active: $page.url === '/' || $page.url === '/dashboard' }">
                        <Link :href="route('dashboard')" class="menu-link">
                            <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </Link>
                    </li>

                    <!-- Module Menus -->
                    <template v-for="module in $page.props.modules" :key="module.name">
                        <li class="menu-header small">
                            <span class="menu-header-text">{{ module.alias }}</span>
                        </li>
                        
                        <slot :name="`menu-${module.name.toLowerCase()}`">
                            <!-- Default module menu item -->
                            <li class="menu-item">
                                <Link :href="route(`${module.name.toLowerCase()}.index`)" class="menu-link">
                                    <i class="menu-icon tf-icons mdi mdi-package-variant"></i>
                                    <div>{{ module.alias }}</div>
                                </Link>
                            </li>
                        </slot>
                    </template>

                    <!-- Custom Menu Slot -->
                    <slot name="menu"></slot>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="mdi mdi-menu mdi-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                                    <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
                                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="/materialize/images/avatars/1.png" alt class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="/materialize/images/avatars/1.png" alt class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block">{{ $page.props.auth.user?.name || 'Guest' }}</span>
                                                    <small class="text-muted">{{ $page.props.auth.user?.email || '' }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="mdi mdi-account-outline me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="mdi mdi-cog-outline me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <Link :href="route('logout')" method="post" as="a" class="dropdown-item">
                                            <i class="mdi mdi-logout me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
                        <i class="mdi mdi-close search-toggler cursor-pointer"></i>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Page Header -->
                        <div class="row" v-if="$slots.header">
                            <div class="col-12">
                                <slot name="header"></slot>
                            </div>
                        </div>

                        <!-- Flash Messages -->
                        <Alert 
                            v-if="$page.props.flash.success" 
                            type="success" 
                            :message="$page.props.flash.success" 
                            dismissible 
                        />
                        <Alert 
                            v-if="$page.props.flash.error" 
                            type="danger" 
                            :message="$page.props.flash.error" 
                            dismissible 
                        />
                        <Alert 
                            v-if="$page.props.flash.warning" 
                            type="warning" 
                            :message="$page.props.flash.warning" 
                            dismissible 
                        />
                        <Alert 
                            v-if="$page.props.flash.info" 
                            type="info" 
                            :message="$page.props.flash.info" 
                            dismissible 
                        />

                        <!-- Main Content -->
                        <slot></slot>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                                <div class="text-body mb-2 mb-md-0">
                                    © {{ new Date().getFullYear() }}, made with <span class="text-danger"><i class="tf-icons mdi mdi-heart"></i></span> by
                                    <a href="#" target="_blank" class="footer-link fw-medium">Your Company</a>
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="#" class="footer-link me-4" target="_blank">License</a>
                                    <a href="#" target="_blank" class="footer-link me-4">Documentation</a>
                                    <a href="#" target="_blank" class="footer-link">Support</a>
                                </div>
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
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
