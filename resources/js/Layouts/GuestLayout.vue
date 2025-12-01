<template>
    <!-- Simple guest layout - no sidebar, no navbar -->
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Page Content -->
            <slot />
        </div>
    </div>
</template>

<script setup>
defineProps({
    appName: {
        type: String,
        default: 'Laravel'
    }
});
</script>
