<template>
    <div class="card" :class="cardClass">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="content-left">
                    <span class="text-muted d-block mb-1" v-if="subtitle">{{ subtitle }}</span>
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0 me-2">{{ formattedValue }}</h4>
                        <span v-if="trend" :class="trendClass">
                            <i :class="trendIcon"></i>
                            {{ trend }}
                        </span>
                    </div>
                    <small v-if="description" class="mb-0">{{ description }}</small>
                </div>
                <span v-if="icon" class="badge rounded-pill p-2" :class="iconBadgeClass">
                    <i :class="icon" class="icon-lg"></i>
                </span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    subtitle: {
        type: String,
        default: ''
    },
    value: {
        type: [Number, String],
        required: true
    },
    trend: {
        type: String,
        default: null // e.g., '+12%', '-5%'
    },
    description: {
        type: String,
        default: ''
    },
    icon: {
        type: String,
        default: null
    },
    variant: {
        type: String,
        default: 'primary',
        validator: (value) => ['primary', 'secondary', 'success', 'danger', 'warning', 'info'].includes(value)
    },
    cardClass: {
        type: String,
        default: ''
    },
    formatNumber: {
        type: Boolean,
        default: true
    }
});

const formattedValue = computed(() => {
    if (!props.formatNumber || typeof props.value !== 'number') {
        return props.value;
    }
    return new Intl.NumberFormat('en-US').format(props.value);
});

const trendClass = computed(() => {
    if (!props.trend) return '';

    const isPositive = props.trend.includes('+') || !props.trend.includes('-');
    return isPositive ? 'text-success' : 'text-danger';
});

const trendIcon = computed(() => {
    if (!props.trend) return '';

    const isPositive = props.trend.includes('+') || !props.trend.includes('-');
    return isPositive ? 'bx bx-trending-up' : 'bx bx-trending-down';
});

const iconBadgeClass = computed(() => {
    return `bg-label-${props.variant}`;
});
</script>

<style scoped>
.icon-lg {
    font-size: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

.badge.rounded-pill {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
