<template>
    <div class="code-highlight-wrapper" :class="wrapperClass">
        <div v-if="showHeader" class="code-header d-flex justify-content-between align-items-center">
            <span v-if="title" class="code-title">{{ title }}</span>
            <span class="code-language badge bg-label-secondary">{{ language }}</span>
            <button
                v-if="copyable"
                class="btn btn-sm btn-icon"
                @click="copyCode"
                :title="copied ? 'Copied!' : 'Copy code'"
            >
                <i :class="copied ? 'bx bx-check' : 'bx bx-copy'"></i>
            </button>
        </div>
        <prism-component
            :language="language"
            :code="code"
            :inline="inline"
        />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import PrismComponent from 'vue-prism-component';
import 'prismjs';
import 'prismjs/themes/prism-tomorrow.css';

// Import additional languages as needed
import 'prismjs/components/prism-javascript';
import 'prismjs/components/prism-typescript';
import 'prismjs/components/prism-css';
import 'prismjs/components/prism-scss';
import 'prismjs/components/prism-bash';
import 'prismjs/components/prism-json';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-python';
import 'prismjs/components/prism-sql';
import 'prismjs/components/prism-yaml';
import 'prismjs/components/prism-markdown';

const props = defineProps({
    code: {
        type: String,
        required: true
    },
    language: {
        type: String,
        default: 'javascript'
    },
    inline: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: ''
    },
    copyable: {
        type: Boolean,
        default: true
    },
    showHeader: {
        type: Boolean,
        default: true
    },
    wrapperClass: {
        type: String,
        default: ''
    }
});

const copied = ref(false);

const copyCode = async () => {
    try {
        await navigator.clipboard.writeText(props.code);
        copied.value = true;
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch (err) {
        console.error('Failed to copy code:', err);
    }
};
</script>

<style scoped>
.code-highlight-wrapper {
    position: relative;
    border-radius: 0.375rem;
    overflow: hidden;
    margin-bottom: 1rem;
}

.code-header {
    background: #2d2d2d;
    color: #fff;
    padding: 0.5rem 1rem;
    border-bottom: 1px solid #3d3d3d;
}

.code-title {
    font-size: 0.875rem;
    font-weight: 500;
}

.code-language {
    font-size: 0.75rem;
    text-transform: uppercase;
}

.btn-icon {
    color: #fff;
    padding: 0.25rem 0.5rem;
}

.btn-icon:hover {
    background: rgba(255, 255, 255, 0.1);
}

:deep(pre) {
    margin: 0;
    border-radius: 0;
}

:deep(code) {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 0.875rem;
}
</style>
