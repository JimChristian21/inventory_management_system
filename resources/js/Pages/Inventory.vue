<script setup>
    import { Head } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import ItemsTable from '../Components/Items/ItemsTable.vue';

    const props = defineProps({
        items: {
            type: Object,
            required: true
        }
    });
</script>

<template>
    <Head title="Inventory" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                <font-awesome-icon :icon="['fas', 'warehouse']" />
                Inventory
            </h2>
        </template>

        <div class="py-12 px-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <ItemsTable 
                        :items="props.items"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>