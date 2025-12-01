import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

export function useModal(options = {}) {
    const {
        createPath,
        editPath = '/edit',
        indexRoute,
        createTitle = 'Create New Item',
        editTitle = 'Edit Item',
        createComponentLoader,
        editComponentLoader
    } = options;

    const page = usePage();
    const showModal = ref(false);
    const modalComponent = ref(null);
    const modalTitle = ref('');

    // Watch for URL changes to detect modal
    watch(() => page.url, (url) => {
        if (createPath && url.includes(createPath)) {
            if (createComponentLoader) {
                modalComponent.value = createComponentLoader();
            }
            modalTitle.value = createTitle;
            showModal.value = true;
        } else if (url.includes(editPath)) {
            if (editComponentLoader) {
                modalComponent.value = editComponentLoader();
            }
            modalTitle.value = editTitle;
            showModal.value = true;
        } else {
            showModal.value = false;
            modalComponent.value = null;
        }
    }, { immediate: true });

    const closeModal = () => {
        router.visit(indexRoute, {
            preserveScroll: true
        });
    };

    return {
        showModal,
        modalComponent,
        modalTitle,
        closeModal
    };
}
