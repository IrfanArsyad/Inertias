<template>
    <Teleport to="body">
        <!-- Modal Backdrop -->
        <Transition name="fade">
            <div
                v-if="show"
                class="modal-backdrop fade show"
                @click="handleBackdropClick"
            ></div>
        </Transition>

        <!-- Modal Container -->
        <Transition name="modal">
            <div
                v-if="show"
                class="modal fade show"
                tabindex="-1"
                style="display: block;"
                @click.self="handleBackdropClick"
            >
                <slot></slot>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['close']);

const handleBackdropClick = () => {
    if (props.closeOnBackdrop) {
        emit('close');
    }
};

// Handle body scroll
watch(() => props.show, (newVal) => {
    if (newVal) {
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
    } else {
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
    }
}, { immediate: true });

// Handle ESC key
const handleKeydown = (e) => {
    if (e.key === 'Escape' && props.show) {
        emit('close');
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
});
</script>

<style scoped>
.modal.show {
    opacity: 1;
}

.modal-backdrop.show {
    opacity: 0.5;
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.15s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.15s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-active .modal-dialog,
.modal-leave-active .modal-dialog {
    transition: transform 0.3s ease;
}

.modal-enter-from .modal-dialog,
.modal-leave-to .modal-dialog {
    transform: translateY(-50px);
}
</style>
