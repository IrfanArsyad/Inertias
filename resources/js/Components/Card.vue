<template>
    <div class="card" :class="cardClass">
        <div v-if="$slots.header || title" class="card-header" :class="headerClass">
            <slot name="header">
                <h5 class="card-title mb-0">{{ title }}</h5>
            </slot>
        </div>

        <div class="card-body" :class="bodyClass">
            <slot></slot>
        </div>

        <div v-if="$slots.footer" class="card-footer" :class="footerClass">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: ''
    },
    cardClass: {
        type: String,
        default: ''
    },
    headerClass: {
        type: String,
        default: ''
    },
    bodyClass: {
        type: String,
        default: ''
    },
    footerClass: {
        type: String,
        default: ''
    }
});
</script>
