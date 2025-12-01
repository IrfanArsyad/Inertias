<template>
    <div class="mb-3" :class="wrapperClass">
        <label v-if="label" :for="id" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>

        <textarea
            :id="id"
            :class="textareaClasses"
            :placeholder="placeholder"
            :value="modelValue"
            @input="handleInput"
            @blur="handleBlur"
            @focus="handleFocus"
            :disabled="disabled"
            :readonly="readonly"
            :required="required"
            :rows="rows"
            :maxlength="maxlength"
            v-bind="$attrs"
        ></textarea>

        <div v-if="showCounter" class="d-flex justify-content-between">
            <small v-if="hint && !error" class="form-text text-muted">
                {{ hint }}
            </small>
            <small v-if="maxlength" class="form-text text-muted">
                {{ characterCount }} / {{ maxlength }}
            </small>
        </div>

        <div v-if="error" class="invalid-feedback d-block">
            {{ error }}
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    label: {
        type: String,
        default: ''
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
    rows: {
        type: [Number, String],
        default: 3
    },
    maxlength: {
        type: [Number, String],
        default: null
    },
    showCounter: {
        type: Boolean,
        default: true
    },
    wrapperClass: {
        type: String,
        default: ''
    },
    textareaClass: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:modelValue', 'blur', 'focus', 'change']);

const id = computed(() => {
    return props.label 
        ? props.label.toLowerCase().replace(/\s+/g, '-') 
        : `textarea-${Math.random().toString(36).substr(2, 9)}`;
});

const textareaClasses = computed(() => {
    const classes = ['form-control'];
    
    if (props.error) {
        classes.push('is-invalid');
    }
    
    if (props.textareaClass) {
        classes.push(props.textareaClass);
    }
    
    return classes.join(' ');
});

const characterCount = computed(() => {
    return props.modelValue ? props.modelValue.length : 0;
});

const handleInput = (event) => {
    const value = event.target.value;
    emit('update:modelValue', value);
    emit('change', value);
};

const handleBlur = (event) => {
    emit('blur', event);
};

const handleFocus = (event) => {
    emit('focus', event);
};
</script>
