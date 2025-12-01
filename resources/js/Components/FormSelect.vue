<template>
    <div class="mb-3" :class="wrapperClass">
        <label v-if="label" :for="id" class="form-label">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>

        <select
            :id="id"
            :class="selectClasses"
            :value="modelValue"
            @change="handleChange"
            :disabled="disabled"
            :required="required"
            v-bind="$attrs"
        >
            <option value="" v-if="placeholder" disabled>{{ placeholder }}</option>
            
            <template v-if="grouped">
                <optgroup 
                    v-for="(group, groupKey) in options" 
                    :key="groupKey"
                    :label="groupKey"
                >
                    <option 
                        v-for="option in group" 
                        :key="getOptionValue(option)"
                        :value="getOptionValue(option)"
                        :selected="modelValue === getOptionValue(option)"
                    >
                        {{ getOptionLabel(option) }}
                    </option>
                </optgroup>
            </template>
            
            <template v-else>
                <option 
                    v-for="option in options" 
                    :key="getOptionValue(option)"
                    :value="getOptionValue(option)"
                    :selected="modelValue === getOptionValue(option)"
                >
                    {{ getOptionLabel(option) }}
                </option>
            </template>
        </select>

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

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean, null],
        default: ''
    },
    label: {
        type: String,
        default: ''
    },
    options: {
        type: [Array, Object],
        required: true,
        // Array of objects: [{ value: 1, label: 'Option 1' }]
        // Array of strings: ['Option 1', 'Option 2']
        // Object for grouped: { 'Group 1': [...], 'Group 2': [...] }
    },
    valueKey: {
        type: String,
        default: 'value'
    },
    labelKey: {
        type: String,
        default: 'label'
    },
    placeholder: {
        type: String,
        default: 'Select an option'
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
    required: {
        type: Boolean,
        default: false
    },
    grouped: {
        type: Boolean,
        default: false
    },
    wrapperClass: {
        type: String,
        default: ''
    },
    selectClass: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:modelValue', 'change']);

const id = computed(() => {
    return props.label 
        ? props.label.toLowerCase().replace(/\s+/g, '-') 
        : `select-${Math.random().toString(36).substr(2, 9)}`;
});

const selectClasses = computed(() => {
    const classes = ['form-select'];
    
    if (props.error) {
        classes.push('is-invalid');
    }
    
    if (props.selectClass) {
        classes.push(props.selectClass);
    }
    
    return classes.join(' ');
});

const getOptionValue = (option) => {
    if (typeof option === 'object' && option !== null) {
        return option[props.valueKey];
    }
    return option;
};

const getOptionLabel = (option) => {
    if (typeof option === 'object' && option !== null) {
        return option[props.labelKey];
    }
    return option;
};

const handleChange = (event) => {
    let value = event.target.value;
    
    // Try to convert to original type
    if (typeof props.modelValue === 'number') {
        value = Number(value);
    } else if (typeof props.modelValue === 'boolean') {
        value = value === 'true';
    }
    
    emit('update:modelValue', value);
    emit('change', value);
};
</script>
