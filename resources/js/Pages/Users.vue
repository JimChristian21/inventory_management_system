<script setup>
    import { Head } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Button from "primevue/button";
    import Paginator from '@/Components/Table/Paginator.vue';
    
    const props = defineProps({
        users: Object
    });

    const search = ref('');

    const headers = [
        'Name',
        'Roles',
        'Email',
        'Created',
        'Actions'
    ];

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

        <div class="py-12 px-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="w-full flex justify-end p-2">
                            <input 
                                type="text" 
                                v-model="search"
                                class="rounded-lg"
                                placeholder="Search"
                            />
                        </div>
                        <table class="w-full overflow-scroll">
                            <thead>
                                <tr class="font-bold border-black border-y-2">
                                    <td class="p-2" v-for="header in headers">
                                        {{ header }}
                                    </td>
                                </tr>
                            </thead>

                            <tbody>
                                <tr 
                                    v-for="user in props.users.data" 
                                    :key="1"
                                    class="border-b-2 border-slate-500 p-10"
                                >
                                    <td class="p-2">{{ user.name }}</td>
                                    <td class="p-2">Roles</td>
                                    <td class="p-2">{{ user.email }}</td>
                                    <td class="p-2">{{ user.created_at }}</td>
                                    <td class="p-2">
                                        <Button>ACTIONS</Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator 
                            :links="props.users.links" 
                            :perPage="props.users.per_page"
                            :from="props.users.from" 
                            :to="props.users.to"
                            :total="props.users.total"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>