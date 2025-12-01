<template>
    
        <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">eCommerce Dashboard</h4>
                    <p class="text-muted mb-0">Welcome to your dashboard! Here's what's happening with your store today.</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary">
                        <i class="mdi mdi-plus me-1"></i>
                        Generate Report
                    </button>
                </div>
            </div>

            <!-- Top Stats Cards -->
            <div class="row">
                <!-- Total Sales -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-muted d-block mb-1">Total Sales</span>
                                    <div class="d-flex align-items-center mb-1">
                                        <h4 class="mb-0 me-2">42.5k</h4>
                                        <span class="badge bg-label-success">+18%</span>
                                    </div>
                                    <small class="mb-0">Last week analytics</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="mdi mdi-chart-timeline-variant mdi-24px"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Customers -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-muted d-block mb-1">New Customers</span>
                                    <div class="d-flex align-items-center mb-1">
                                        <h4 class="mb-0 me-2">8,458</h4>
                                        <span class="badge bg-label-success">+12%</span>
                                    </div>
                                    <small class="mb-0">Last week analytics</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="mdi mdi-account-outline mdi-24px"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Profit -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-muted d-block mb-1">Total Profit</span>
                                    <div class="d-flex align-items-center mb-1">
                                        <h4 class="mb-0 me-2">$28.5k</h4>
                                        <span class="badge bg-label-success">+22%</span>
                                    </div>
                                    <small class="mb-0">Last week analytics</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="mdi mdi-currency-usd mdi-24px"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Transactions -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-muted d-block mb-1">New Transactions</span>
                                    <div class="d-flex align-items-center mb-1">
                                        <h4 class="mb-0 me-2">2,450</h4>
                                        <span class="badge bg-label-danger">-8%</span>
                                    </div>
                                    <small class="mb-0">Last week analytics</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="mdi mdi-currency-usd-circle mdi-24px"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ratings & Sessions -->
            <div class="row">
                <!-- Ratings -->
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Ratings</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column">
                                    <h1 class="mb-1">8.14k</h1>
                                    <span class="text-muted">Total Reviews</span>
                                </div>
                                <span class="badge bg-label-success">+15.6%</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <i class="mdi mdi-star text-warning mdi-24px"></i>
                                <i class="mdi mdi-star text-warning mdi-24px"></i>
                                <i class="mdi mdi-star text-warning mdi-24px"></i>
                                <i class="mdi mdi-star text-warning mdi-24px"></i>
                                <i class="mdi mdi-star-outline text-muted mdi-24px"></i>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>5 star</span>
                                    <span>72%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: 72%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>4 star</span>
                                    <span>18%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: 18%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>3 star</span>
                                    <span>8%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: 8%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sessions -->
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Sessions</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column">
                                    <h1 class="mb-1">12.2k</h1>
                                    <span class="text-muted">Active Users</span>
                                </div>
                                <span class="badge bg-label-danger">-25.5%</span>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Mobile</span>
                                    <span class="fw-semibold">6.2k</span>
                                </div>
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: 51%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Desktop</span>
                                    <span class="fw-semibold">4.5k</span>
                                </div>
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 37%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tablet</span>
                                    <span class="fw-semibold">1.5k</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" style="width: 12%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Earning -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-1">Weekly Earning</h5>
                                <span class="badge bg-label-success">+62%</span>
                            </div>
                            <p class="card-subtitle">Mobiles & Computers</p>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="d-flex align-items-center">
                                        <i class="mdi mdi-circle mdi-12px text-primary me-2"></i>
                                        <span>Mobiles</span>
                                    </span>
                                    <span class="fw-semibold">24</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="d-flex align-items-center">
                                        <i class="mdi mdi-circle mdi-12px text-success me-2"></i>
                                        <span>Tablets</span>
                                    </span>
                                    <span class="fw-semibold">12</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="d-flex align-items-center">
                                        <i class="mdi mdi-circle mdi-12px text-info me-2"></i>
                                        <span>Accessories</span>
                                    </span>
                                    <span class="fw-semibold">50</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="d-flex align-items-center">
                                        <i class="mdi mdi-circle mdi-12px text-warning me-2"></i>
                                        <span>Computers</span>
                                    </span>
                                    <span class="fw-semibold">38</span>
                                </div>
                            </div>
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-0">Total</h6>
                                    <h6 class="mb-0 text-primary">$23.5k</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales & Activity -->
            <div class="row">
                <!-- Sales by Countries -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Sales by Countries</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <li class="d-flex align-items-center mb-4">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="fis fi fi-us rounded-circle fs-2"></i>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">United States</h6>
                                            <small class="text-muted">894k</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">$25.8k</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="fis fi fi-br rounded-circle fs-2"></i>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Brazil</h6>
                                            <small class="text-muted">645k</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">$16.2k</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="fis fi fi-au rounded-circle fs-2"></i>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Australia</h6>
                                            <small class="text-muted">148k</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">$12.5k</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="fis fi fi-in rounded-circle fs-2"></i>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">India</h6>
                                            <small class="text-muted">234k</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">$8.7k</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Activity Timeline</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">View All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="timeline ms-1 mb-0">
                                <li class="timeline-item timeline-item-transparent ps-4">
                                    <span class="timeline-point timeline-point-primary"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">12 Invoices have been paid</h6>
                                            <small class="text-muted">12 min ago</small>
                                        </div>
                                        <p class="mb-2">Invoices have been paid to the company</p>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent ps-4">
                                    <span class="timeline-point timeline-point-success"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">Client Meeting</h6>
                                            <small class="text-muted">45 min ago</small>
                                        </div>
                                        <p class="mb-2">Project meeting with john @10:15am</p>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent ps-4">
                                    <span class="timeline-point timeline-point-info"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">Create a new project</h6>
                                            <small class="text-muted">2 day ago</small>
                                        </div>
                                        <p class="mb-2">Add files to new design folder</p>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent ps-4">
                                    <span class="timeline-point timeline-point-warning"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">Shared 2 New Project Files</h6>
                                            <small class="text-muted">3 day ago</small>
                                        </div>
                                        <p class="mb-0">Sent by Mollie Dixon</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Transactions -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Transactions</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">View All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-4">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <div class="avatar-initial bg-label-success rounded">
                                            <i class="mdi mdi-trending-up mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Paypal</h6>
                                            <small class="text-muted">Received Money</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-success">+$24,820</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <div class="avatar-initial bg-label-warning rounded">
                                            <i class="mdi mdi-credit-card mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Credit Card</h6>
                                            <small class="text-muted">Digital Ocean</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-danger">-$1,250</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <div class="avatar-initial bg-label-info rounded">
                                            <i class="mdi mdi-cash mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Mastercard</h6>
                                            <small class="text-muted">Netflix Subscription</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-danger">-$99</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <div class="avatar-initial bg-label-primary rounded">
                                            <i class="mdi mdi-bank mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Transfer</h6>
                                            <small class="text-muted">Refund</small>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-success">+$8,934</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Top Products</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);">View All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Stock</th>
                                        <th>Revenue</th>
                                        <th>Sales</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded bg-label-primary">
                                                        <i class="mdi mdi-cellphone"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">iPhone 13 Pro</h6>
                                                    <small class="text-muted">#SKU: IPN-13-PRO</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-label-primary">Mobile</span></td>
                                        <td><span class="text-success">In Stock</span></td>
                                        <td>$999,999</td>
                                        <td>1,234</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="mdi mdi-eye-outline me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);">
                                                        <i class="mdi mdi-delete-outline me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded bg-label-success">
                                                        <i class="mdi mdi-tshirt-crew"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Nike Air Max</h6>
                                                    <small class="text-muted">#SKU: NAM-2024</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-label-success">Fashion</span></td>
                                        <td><span class="text-warning">Low Stock</span></td>
                                        <td>$149,999</td>
                                        <td>987</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="mdi mdi-eye-outline me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);">
                                                        <i class="mdi mdi-delete-outline me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded bg-label-info">
                                                        <i class="mdi mdi-laptop"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">MacBook Pro M3</h6>
                                                    <small class="text-muted">#SKU: MBP-M3-24</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-label-info">Computer</span></td>
                                        <td><span class="text-success">In Stock</span></td>
                                        <td>$2,499,999</td>
                                        <td>567</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="mdi mdi-eye-outline me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);">
                                                        <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);">
                                                        <i class="mdi mdi-delete-outline me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    
</template>

<script setup>

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({})
    }
});
</script>

<style scoped>
/* Card Hover Effects */
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 25px 0 rgba(0, 0, 0, 0.1);
}

/* Statistics Cards Styling */
.avatar-initial {
    font-size: 1.5rem;
}

/* Timeline Styles */
.timeline {
    padding: 0;
    margin: 0;
    list-style: none;
    position: relative;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 0.4375rem;
    top: 0;
    width: 2px;
    height: 100%;
    background-color: #e7eaf0;
}

.timeline-point {
    position: absolute;
    left: 0;
    top: 0.25rem;
    width: 0.875rem;
    height: 0.875rem;
    border-radius: 50%;
    background-color: #fff;
    border: 2px solid;
}

.timeline-point-primary {
    border-color: #696cff;
}

.timeline-point-success {
    border-color: #71dd37;
}

.timeline-point-info {
    border-color: #03c3ec;
}

.timeline-point-warning {
    border-color: #ffab00;
}

/* Avatar Styles */
.avatar {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-sm {
    width: 2rem;
    height: 2rem;
}

.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

/* Table Styles */
.table th {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #566a7f;
    padding: 0.75rem 1.25rem;
}

.table td {
    padding: 0.75rem 1.25rem;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: rgba(67, 89, 113, 0.04);
}

/* Flag Icons */
.fis {
    font-size: 2rem;
}

/* List Styles */
ul {
    list-style: none;
}
</style>
