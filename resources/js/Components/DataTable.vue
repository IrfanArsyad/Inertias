<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ title }}</h5>
            <div class="d-flex gap-2">
                <!-- Search -->
                <div class="input-group input-group-merge" v-if="searchable">
                    <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                    <input
                        type="text"
                        class="form-control"
                        :placeholder="searchPlaceholder"
                        v-model="search"
                        @input="handleSearch"
                    />
                </div>

                <!-- Action Buttons Slot -->
                <slot name="actions"></slot>

                <!-- Add Button -->
                <Link 
                    v-if="createRoute" 
                    :href="createRoute" 
                    class="btn btn-primary"
                >
                    <i class="mdi mdi-plus me-1"></i>{{ createLabel }}
                </Link>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th v-if="selectable">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                @change="toggleSelectAll"
                                :checked="isAllSelected"
                            />
                        </th>
                        <th 
                            v-for="column in columns" 
                            :key="column.key"
                            :class="column.headerClass"
                            @click="column.sortable ? handleSort(column.key) : null"
                            :style="column.sortable ? 'cursor: pointer' : ''"
                        >
                            {{ column.label }}
                            <i 
                                v-if="column.sortable" 
                                class="mdi ms-1"
                                :class="{
                                    'mdi-arrow-up': sortKey === column.key && sortOrder === 'asc',
                                    'mdi-arrow-down': sortKey === column.key && sortOrder === 'desc',
                                    'mdi-sort': sortKey !== column.key
                                }"
                            ></i>
                        </th>
                        <th v-if="hasActions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td :colspan="totalColumns" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </td>
                    </tr>
                    <tr v-else-if="!items || items.length === 0">
                        <td :colspan="totalColumns" class="text-center py-5">
                            <div class="text-muted">
                                <i class="mdi mdi-database-off-outline d-block mb-2" style="font-size: 3rem;"></i>
                                <h6 class="mt-3 mb-1">{{ emptyTitle }}</h6>
                                <p class="text-muted mb-0">{{ emptyText }}</p>
                            </div>
                        </td>
                    </tr>
                    <template v-else>
                        <tr v-for="(item, index) in items" :key="getItemKey(item, index)">
                            <td v-if="selectable">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input"
                                    :value="getItemKey(item, index)"
                                    v-model="selected"
                                    @change="handleSelect"
                                />
                            </td>
                            <td 
                                v-for="column in columns" 
                                :key="column.key"
                                :class="column.cellClass"
                            >
                                <!-- Custom slot for column -->
                                <slot 
                                    :name="`cell-${column.key}`" 
                                    :item="item" 
                                    :value="getNestedValue(item, column.key)"
                                >
                                    <!-- Format value if formatter provided -->
                                    <template v-if="column.formatter">
                                        {{ column.formatter(getNestedValue(item, column.key), item) }}
                                    </template>
                                    <!-- Default display -->
                                    <template v-else>
                                        {{ getNestedValue(item, column.key) }}
                                    </template>
                                </slot>
                            </td>
                            <td v-if="hasActions">
                                <slot name="actions" :item="item" :index="index">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- Edit Button -->
                                            <Link
                                                v-if="editRoute"
                                                :href="typeof editRoute === 'function' ? editRoute(item) : `${editRoute}/${getItemKey(item, index)}/edit`"
                                                class="dropdown-item"
                                                :preserve-scroll="useModalForEdit"
                                            >
                                                <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                            </Link>
                                            <Link 
                                                v-if="showRoute" 
                                                :href="typeof showRoute === 'function' ? showRoute(item) : `${showRoute}/${getItemKey(item, index)}`"
                                                class="dropdown-item"
                                            >
                                                <i class="mdi mdi-eye-outline me-1"></i> View
                                            </Link>
                                            <a 
                                                v-if="deleteRoute"
                                                href="javascript:void(0);" 
                                                class="dropdown-item text-danger"
                                                @click="handleDelete(item, index)"
                                            >
                                                <i class="mdi mdi-delete-outline me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </slot>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer" v-if="pagination && !loading">
            <Pagination
                :data="pagination"
                @page-changed="handlePageChange"
            />
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" ref="deleteModalRef" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-0">
                    <i class="mdi mdi-alert-circle-outline text-warning" style="font-size: 3.5rem;"></i>
                    <h5 class="mt-2 mb-1">Are you sure?</h5>
                    <p class="text-muted mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" @click="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { Modal } from 'bootstrap';
import Pagination from './Pagination.vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Data Table'
    },
    columns: {
        type: Array,
        required: true,
        // Example: [{ key: 'name', label: 'Name', sortable: true, formatter: (val) => val.toUpperCase() }]
    },
    items: {
        type: Array,
        default: () => []
    },
    pagination: {
        type: Object,
        default: null
        // Laravel pagination object
    },
    loading: {
        type: Boolean,
        default: false
    },
    selectable: {
        type: Boolean,
        default: false
    },
    searchable: {
        type: Boolean,
        default: true
    },
    searchPlaceholder: {
        type: String,
        default: 'Search...'
    },
    emptyText: {
        type: String,
        default: 'No data available'
    },
    emptyTitle: {
        type: String,
        default: 'No Data Found'
    },
    createRoute: {
        type: String,
        default: null
    },
    createLabel: {
        type: String,
        default: 'Add New'
    },
    editRoute: {
        type: [String, Function],
        default: null
    },
    showRoute: {
        type: [String, Function],
        default: null
    },
    deleteRoute: {
        type: [String, Function],
        default: null
    },
    itemKey: {
        type: String,
        default: 'id'
    },
    useModalForEdit: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['search', 'sort', 'page-change', 'select', 'delete']);

const search = ref('');
const sortKey = ref('');
const sortOrder = ref('asc');
const selected = ref([]);
const deleteModalRef = ref(null);
let deleteModal = null;
const pendingDeleteItem = ref(null);
const pendingDeleteIndex = ref(null);

onMounted(() => {
    if (deleteModalRef.value) {
        deleteModal = new Modal(deleteModalRef.value);
    }
});

onBeforeUnmount(() => {
    if (deleteModal) {
        deleteModal.dispose();
    }
});

const hasActions = computed(() => {
    return props.editRoute || props.showRoute || props.deleteRoute;
});

const totalColumns = computed(() => {
    let count = props.columns.length;
    if (props.selectable) count++;
    if (hasActions.value) count++;
    return count;
});

const isAllSelected = computed(() => {
    return props.items.length > 0 && selected.value.length === props.items.length;
});

const handleSearch = debounce(() => {
    emit('search', search.value);
}, 300);

const handleSort = (key) => {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = key;
        sortOrder.value = 'asc';
    }
    emit('sort', { key: sortKey.value, order: sortOrder.value });
};

const handlePageChange = (page) => {
    emit('page-change', page);
};

const toggleSelectAll = () => {
    if (isAllSelected.value) {
        selected.value = [];
    } else {
        selected.value = props.items.map((item, index) => getItemKey(item, index));
    }
    handleSelect();
};

const handleSelect = () => {
    emit('select', selected.value);
};

const handleDelete = (item, index) => {
    pendingDeleteItem.value = item;
    pendingDeleteIndex.value = index;
    if (deleteModal) {
        deleteModal.show();
    }
};

const confirmDelete = () => {
    const item = pendingDeleteItem.value;
    const index = pendingDeleteIndex.value;

    if (!item) return;

    const key = getItemKey(item, index);
    const url = typeof props.deleteRoute === 'function'
        ? props.deleteRoute(item)
        : `${props.deleteRoute}/${key}`;

    if (deleteModal) {
        deleteModal.hide();
    }

    if (emit('delete', item, index) !== false) {
        router.delete(url);
    }

    pendingDeleteItem.value = null;
    pendingDeleteIndex.value = null;
};

const getItemKey = (item, index) => {
    return item[props.itemKey] || index;
};

const getNestedValue = (obj, path) => {
    return path.split('.').reduce((current, key) => current?.[key], obj);
};

// Watch for search changes
watch(search, (newVal) => {
    if (newVal === '') {
        handleSearch();
    }
});
</script>

<style scoped>
.table th[style*="cursor: pointer"]:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
</style>
