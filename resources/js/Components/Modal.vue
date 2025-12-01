<template>
    <Teleport to="body">
        <div 
            v-if="show"
            class="modal fade"
            :class="{ show: show }"
            :id="id"
            tabindex="-1"
            :aria-labelledby="`${id}Label`"
            aria-hidden="true"
            style="display: block;"
            @click.self="handleBackdropClick"
        >
            <div class="modal-dialog" :class="modalDialogClasses">
                <div class="modal-content">
                    <div v-if="$slots.header || title" class="modal-header">
                        <slot name="header">
                            <h5 class="modal-title" :id="`${id}Label`">{{ title }}</h5>
                            <button 
                                v-if="closable"
                                type="button" 
                                class="btn-close" 
                                @click="close"
                                aria-label="Close"
                            ></button>
                        </slot>
                    </div>

                    <div class="modal-body" :class="bodyClass">
                        <slot></slot>
                    </div>

                    <div v-if="$slots.footer || showFooter" class="modal-footer">
                        <slot name="footer">
                            <button 
                                v-if="cancelButton"
                                type="button" 
                                class="btn btn-label-secondary" 
                                @click="cancel"
                            >
                                {{ cancelText }}
                            </button>
                            <button 
                                v-if="confirmButton"
                                type="button" 
                                :class="confirmButtonClass"
                                @click="confirm"
                                :disabled="confirmDisabled"
                            >
                                {{ confirmText }}
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Backdrop -->
        <div 
            v-if="show && backdrop"
            class="modal-backdrop fade"
            :class="{ show: show }"
        ></div>
    </Teleport>
</template>

<script setup>
import { computed, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: ''
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => {
            return ['sm', 'md', 'lg', 'xl'].includes(value);
        }
    },
    centered: {
        type: Boolean,
        default: false
    },
    scrollable: {
        type: Boolean,
        default: false
    },
    closable: {
        type: Boolean,
        default: true
    },
    backdrop: {
        type: Boolean,
        default: true
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    },
    showFooter: {
        type: Boolean,
        default: false
    },
    cancelButton: {
        type: Boolean,
        default: true
    },
    cancelText: {
        type: String,
        default: 'Cancel'
    },
    confirmButton: {
        type: Boolean,
        default: true
    },
    confirmText: {
        type: String,
        default: 'Confirm'
    },
    confirmVariant: {
        type: String,
        default: 'primary'
    },
    confirmDisabled: {
        type: Boolean,
        default: false
    },
    bodyClass: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:show', 'close', 'cancel', 'confirm']);

const id = computed(() => {
    return `modal-${Math.random().toString(36).substr(2, 9)}`;
});

const modalDialogClasses = computed(() => {
    const classes = [];
    
    if (props.size !== 'md') {
        classes.push(`modal-${props.size}`);
    }
    
    if (props.centered) {
        classes.push('modal-dialog-centered');
    }
    
    if (props.scrollable) {
        classes.push('modal-dialog-scrollable');
    }
    
    return classes.join(' ');
});

const confirmButtonClass = computed(() => {
    return `btn btn-${props.confirmVariant}`;
});

const close = () => {
    emit('update:show', false);
    emit('close');
};

const cancel = () => {
    emit('cancel');
    close();
};

const confirm = () => {
    emit('confirm');
    // Don't auto-close, let parent handle it
};

const handleBackdropClick = () => {
    if (props.closeOnBackdrop && props.closable) {
        close();
    }
};

// Prevent body scroll when modal is open
watch(() => props.show, (newVal) => {
    if (newVal) {
        document.body.classList.add('modal-open');
    } else {
        document.body.classList.remove('modal-open');
    }
});
</script>

<style scoped>
.modal.show {
    opacity: 1;
}

.modal-backdrop.show {
    opacity: 0.5;
}
</style>
