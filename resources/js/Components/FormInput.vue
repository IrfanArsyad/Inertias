<template>
    <div class="mb-3" :class="wrapperClass">
        <label v-if="label" :for="id" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>
        
        <div :class="{ 'input-group': hasPrefix || hasSuffix || hasIcon }">
            <span v-if="hasPrefix" class="input-group-text">
                <slot name="prefix">{{ prefix }}</slot>
            </span>
            
            <span v-if="hasIcon && !hasPrefix" class="input-group-text">
                <i :class="icon"></i>
            </span>

            <input
                :id="id"
                :type="type"
                :class="inputClasses"
                :placeholder="placeholder"
                :value="modelValue"
                @input="handleInput"
                @blur="handleBlur"
                @focus="handleFocus"
                :disabled="disabled"
                :readonly="readonly"
                :required="required"
                :min="min"
                :max="max"
                :step="step"
                :pattern="pattern"
                :autocomplete="autocomplete"
                v-bind="$attrs"
            />

            <span v-if="hasSuffix" class="input-group-text">
                <slot name="suffix">{{ suffix }}</slot>
            </span>
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
import { computed, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    label: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'text',
        validator: (value) => {
            return ['text', 'email', 'password', 'number', 'tel', 'url', 'search', 'date', 'time', 'datetime-local', 'month', 'week'].includes(value);
        }
    },
    placeholder: {
        type: String,
        default: ''
    },
    hint: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    },
    prefix: {
        type: String,
        default: ''
    },
    suffix: {
        type: String,
        default: ''
    },
    icon: {
        type: String,
        default: ''
    },
    wrapperClass: {
        type: String,
        default: ''
    },
    inputClass: {
        type: String,
        default: ''
    },
    min: {
        type: [String, Number],
        default: null
    },
    max: {
        type: [String, Number],
        default: null
    },
    step: {
        type: [String, Number],
        default: null
    },
    pattern: {
        type: String,
        default: null
    },
    autocomplete: {
        type: String,
        default: 'off'
    }
});

const emit = defineEmits(['update:modelValue', 'blur', 'focus', 'change']);

const id = computed(() => {
    return props.label 
        ? props.label.toLowerCase().replace(/\s+/g, '-') 
        : `input-${Math.random().toString(36).substr(2, 9)}`;
});

const hasPrefix = computed(() => {
    return !!props.prefix || !!slots.prefix;
});

const hasSuffix = computed(() => {
    return !!props.suffix || !!slots.suffix;
});

const hasIcon = computed(() => {
    return !!props.icon;
});

const inputClasses = computed(() => {
    const classes = ['form-control'];
    
    if (props.error) {
        classes.push('is-invalid');
    }
    
    if (props.inputClass) {
        classes.push(props.inputClass);
    }
    
    return classes.join(' ');
});

const handleInput = (event) => {
    let value = event.target.value;
    
    // Convert to number if type is number
    if (props.type === 'number') {
        value = value === '' ? null : Number(value);
    }
    
    emit('update:modelValue', value);
    emit('change', value);
};

const handleBlur = (event) => {
    emit('blur', event);
};

const handleFocus = (event) => {
    emit('focus', event);
};

const slots = defineSlots();
</script>
