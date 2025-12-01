<template>
    <div class="mb-3" :class="wrapperClass">
        <label v-if="label" :for="id" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>

        <div :class="{ 'input-group': hasIcon }">
            <span v-if="hasIcon" class="input-group-text">
                <i :class="icon"></i>
            </span>

            <flat-pickr
                :id="id"
                v-model="internalValue"
                :config="pickerConfig"
                :class="inputClasses"
                :placeholder="placeholder"
                :disabled="disabled"
            />
        </div>

        <small v-if="hint && !error" class="form-text text-muted">
            {{ hint }}
        </small>

        <div v-if="error" class="invalid-feedback d-block">
            {{ error }}
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

const props = defineProps({
    modelValue: {
        type: [String, Date, Array],
        default: null
    },
    label: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Select date'
    },
    hint: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
    mode: {
        type: String,
        default: 'single', // single, multiple, range
        validator: (value) => ['single', 'multiple', 'range'].includes(value)
    },
    enableTime: {
        type: Boolean,
        default: false
    },
    time24hr: {
        type: Boolean,
        default: true
    },
    dateFormat: {
        type: String,
        default: null
    },
    minDate: {
        type: [String, Date],
        default: null
    },
    maxDate: {
        type: [String, Date],
        default: null
    },
    disabled: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    },
    icon: {
        type: String,
        default: 'bx bx-calendar'
    },
    wrapperClass: {
        type: String,
        default: ''
    },
    inline: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:modelValue', 'change']);

const id = computed(() => {
    return props.label
        ? props.label.toLowerCase().replace(/\s+/g, '-')
        : `datepicker-${Math.random().toString(36).substr(2, 9)}`;
});

const hasIcon = computed(() => {
    return !!props.icon;
});

const internalValue = computed({
    get: () => props.modelValue,
    set: (val) => {
        emit('update:modelValue', val);
        emit('change', val);
    }
});

const pickerConfig = computed(() => ({
    mode: props.mode,
    enableTime: props.enableTime,
    time_24hr: props.time24hr,
    dateFormat: props.dateFormat || (props.enableTime ? 'Y-m-d H:i' : 'Y-m-d'),
    minDate: props.minDate,
    maxDate: props.maxDate,
    inline: props.inline,
    altInput: true,
    altFormat: props.enableTime ? 'F j, Y H:i' : 'F j, Y'
}));

const inputClasses = computed(() => {
    const classes = ['form-control'];

    if (props.error) {
        classes.push('is-invalid');
    }

    return classes.join(' ');
});
</script>

<style scoped>
/* Override flatpickr styles to match Bootstrap */
:deep(.flatpickr-calendar) {
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

:deep(.flatpickr-day.selected) {
    background: var(--bs-primary);
    border-color: var(--bs-primary);
}

:deep(.flatpickr-day.selected:hover),
:deep(.flatpickr-day.selected:focus) {
    background: var(--bs-primary);
    border-color: var(--bs-primary);
}

:deep(.flatpickr-months .flatpickr-month) {
    background: var(--bs-primary);
}

:deep(.flatpickr-current-month .flatpickr-monthDropdown-months) {
    background: var(--bs-primary);
}

:deep(.flatpickr-weekdays) {
    background: var(--bs-light);
}
</style>
