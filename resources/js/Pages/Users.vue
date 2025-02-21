<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';

    const props = defineProps({
        users: Array
    });

</script>

<template>
    <Head title="User Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                User Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <table>
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Role</td>
                                    <td>Email</td>
                                    <td>Created</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="user in props.users.data" :key="1">
                                    <td>{{ user.name }}</td>
                                    <td>Roles</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.created_at }}</td>
                                    <td>ACTIONS</td>
                                </tr>
                            </tbody>
                        </table>>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>