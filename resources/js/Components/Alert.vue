<template>
    <div 
        v-if="!dismissed"
        class="alert alert-dismissible"
        :class="alertClasses"
        role="alert"
    >
        <div class="d-flex align-items-center">
            <i v-if="icon" :class="iconClass" class="me-2"></i>
            <div class="flex-grow-1">
                <strong v-if="title">{{ title }}</strong>
                <p class="mb-0" v-if="message">{{ message }}</p>
                <slot v-else></slot>
            </div>
        </div>
        <button 
            v-if="dismissible"
            type="button" 
            class="btn-close" 
            @click="dismiss"
            aria-label="Close"
        ></button>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'primary',
        validator: (value) => {
            return ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'].includes(value);
        }
    },
    title: {
        type: String,
        default: ''
    },
    message: {
        type: String,
        default: ''
    },
    icon: {
        type: String,
        default: null
    },
    dismissible: {
        type: Boolean,
        default: false
    },
    autoDismiss: {
        type: Boolean,
        default: false
    },
    autoDismissDelay: {
        type: Number,
        default: 5000
    },
    solid: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['dismiss']);

const dismissed = ref(false);

const alertClasses = computed(() => {
    const classes = [];
    
    if (props.solid) {
        classes.push(`alert-${props.type}`);
    } else {
        classes.push(`alert-label-${props.type}`);
    }
    
    return classes.join(' ');
});

const iconClass = computed(() => {
    if (props.icon) {
        return props.icon;
    }
    
    // Default icons based on type
    const iconMap = {
        success: 'mdi mdi-check-circle-outline',
        danger: 'mdi mdi-alert-circle-outline',
        warning: 'mdi mdi-alert-outline',
        info: 'mdi mdi-information-outline',
        primary: 'mdi mdi-information-outline',
        secondary: 'mdi mdi-information-outline',
        light: 'mdi mdi-information-outline',
        dark: 'mdi mdi-information-outline'
    };
    
    return iconMap[props.type] || iconMap.info;
});

const dismiss = () => {
    dismissed.value = true;
    emit('dismiss');
};

onMounted(() => {
    if (props.autoDismiss) {
        setTimeout(() => {
            dismiss();
        }, props.autoDismissDelay);
    }
});
</script>

<style scoped>
.alert {
    margin-bottom: 1rem;
}

.alert i {
    font-size: 1.25rem;
}
</style>
