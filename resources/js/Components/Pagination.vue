<template>
    <div class="row" v-if="data && data.last_page > 1">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info">
                Showing {{ data.from }} to {{ data.to }} of {{ data.total }} entries
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm justify-content-end">
                    <!-- Previous Button -->
                    <li class="page-item" :class="{ disabled: !data.prev_page_url }">
                        <a 
                            class="page-link" 
                            href="javascript:void(0);"
                            @click="changePage(data.current_page - 1)"
                            :disabled="!data.prev_page_url"
                        >
                            <i class="mdi mdi-chevron-left"></i>
                        </a>
                    </li>

                    <!-- First Page -->
                    <li class="page-item" :class="{ active: data.current_page === 1 }" v-if="showFirstPage">
                        <a class="page-link" href="javascript:void(0);" @click="changePage(1)">1</a>
                    </li>

                    <!-- First Ellipsis -->
                    <li class="page-item disabled" v-if="showFirstEllipsis">
                        <span class="page-link">...</span>
                    </li>

                    <!-- Page Numbers -->
                    <li 
                        v-for="page in visiblePages" 
                        :key="page"
                        class="page-item"
                        :class="{ active: data.current_page === page }"
                    >
                        <a class="page-link" href="javascript:void(0);" @click="changePage(page)">
                            {{ page }}
                        </a>
                    </li>

                    <!-- Last Ellipsis -->
                    <li class="page-item disabled" v-if="showLastEllipsis">
                        <span class="page-link">...</span>
                    </li>

                    <!-- Last Page -->
                    <li 
                        class="page-item" 
                        :class="{ active: data.current_page === data.last_page }"
                        v-if="showLastPage"
                    >
                        <a class="page-link" href="javascript:void(0);" @click="changePage(data.last_page)">
                            {{ data.last_page }}
                        </a>
                    </li>

                    <!-- Next Button -->
                    <li class="page-item" :class="{ disabled: !data.next_page_url }">
                        <a 
                            class="page-link" 
                            href="javascript:void(0);"
                            @click="changePage(data.current_page + 1)"
                            :disabled="!data.next_page_url"
                        >
                            <i class="mdi mdi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Object,
        required: true,
        // Laravel pagination object with: current_page, last_page, from, to, total, prev_page_url, next_page_url
    },
    maxVisiblePages: {
        type: Number,
        default: 5
    },
    preserveScroll: {
        type: Boolean,
        default: false
    },
    preserveState: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['page-changed']);

const visiblePages = computed(() => {
    const current = props.data.current_page;
    const last = props.data.last_page;
    const delta = Math.floor(props.maxVisiblePages / 2);
    
    let start = Math.max(2, current - delta);
    let end = Math.min(last - 1, current + delta);
    
    // Adjust if we're near the beginning
    if (current <= delta + 1) {
        end = Math.min(last - 1, props.maxVisiblePages);
    }
    
    // Adjust if we're near the end
    if (current >= last - delta) {
        start = Math.max(2, last - props.maxVisiblePages + 1);
    }
    
    const pages = [];
    for (let i = start; i <= end; i++) {
        pages.push(i);
    }
    
    return pages;
});

const showFirstPage = computed(() => {
    return props.data.last_page > 1;
});

const showLastPage = computed(() => {
    return props.data.last_page > 1;
});

const showFirstEllipsis = computed(() => {
    return visiblePages.value.length > 0 && visiblePages.value[0] > 2;
});

const showLastEllipsis = computed(() => {
    const lastVisible = visiblePages.value[visiblePages.value.length - 1];
    return visiblePages.value.length > 0 && lastVisible < props.data.last_page - 1;
});

const changePage = (page) => {
    if (page < 1 || page > props.data.last_page || page === props.data.current_page) {
        return;
    }
    
    emit('page-changed', page);
    
    // Use Inertia visit to navigate with query parameter
    const url = new URL(window.location.href);
    url.searchParams.set('page', page);
    
    router.visit(url.toString(), {
        preserveScroll: props.preserveScroll,
        preserveState: props.preserveState,
        only: ['data'] // Only reload data prop
    });
};
</script>

<style scoped>
.page-link {
    cursor: pointer;
}

.page-item.disabled .page-link {
    cursor: not-allowed;
}

.page-item.active .page-link {
    z-index: 3;
}
</style>
