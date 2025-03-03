<script setup>
    import { Head } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import UsersTable from '@/Components/User/UsersTable.vue';

    const props = defineProps({
        users: Object
    });
</script>

<template>
    <Head title="User Management" />
    
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                <font-awesome-icon :icon="['fas', 'users']" /> 
                User Management
            </h2>
        </template>

        <div class="py-12 px-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <UsersTable :users="props.users"/>   
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>