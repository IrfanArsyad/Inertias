<template>
    <transition name="fade">
        <button
            v-show="isVisible"
            class="btn btn-primary btn-icon rounded-pill scroll-to-top-btn"
            @click="scrollToTop"
            :title="label"
        >
            <i :class="icon"></i>
        </button>
    </transition>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    visibleOffset: {
        type: Number,
        default: 300
    },
    icon: {
        type: String,
        default: 'bx bx-up-arrow-alt'
    },
    label: {
        type: String,
        default: 'Scroll to top'
    },
    position: {
        type: Object,
        default: () => ({
            bottom: '20px',
            right: '20px'
        })
    },
    zIndex: {
        type: Number,
        default: 999
    }
});

const isVisible = ref(false);

const handleScroll = () => {
    isVisible.value = window.scrollY > props.visibleOffset;
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.scroll-to-top-btn {
    position: fixed;
    bottom: v-bind('position.bottom');
    right: v-bind('position.right');
    z-index: v-bind('zIndex');
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.scroll-to-top-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.2);
}

.scroll-to-top-btn i {
    font-size: 1.25rem;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>
