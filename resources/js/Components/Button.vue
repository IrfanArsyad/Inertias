<template>
    <component
        :is="componentType"
        :href="href"
        :type="type"
        :class="buttonClasses"
        :disabled="disabled || loading"
        @click="handleClick"
    >
        <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        <slot></slot>
    </component>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    variant: {
        type: String,
        default: 'primary',
        validator: (value) => [
            'primary', 'secondary', 'success', 'danger', 
            'warning', 'info', 'light', 'dark', 'link'
        ].includes(value)
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value)
    },
    outline: {
        type: Boolean,
        default: false
    },
    block: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    loading: {
        type: Boolean,
        default: false
    },
    type: {
        type: String,
        default: 'button'
    },
    href: {
        type: String,
        default: null
    },
    icon: {
        type: String,
        default: null
    }
});

const emit = defineEmits(['click']);

const componentType = computed(() => {
    if (props.href) {
        return Link;
    }
    return 'button';
});

const buttonClasses = computed(() => {
    const classes = ['btn'];

    // Variant
    if (props.outline) {
        classes.push(`btn-outline-${props.variant}`);
    } else {
        classes.push(`btn-${props.variant}`);
    }

    // Size - Bootstrap uses no suffix for default size
    if (props.size === 'sm') {
        classes.push('btn-sm');
    } else if (props.size === 'lg') {
        classes.push('btn-lg');
    }
    // No class needed for 'md' - it's the default Bootstrap size

    // Block
    if (props.block) {
        classes.push('w-100');
    }

    return classes.join(' ');
});

const handleClick = (event) => {
    if (!props.disabled && !props.loading) {
        emit('click', event);
    }
};
</script>
