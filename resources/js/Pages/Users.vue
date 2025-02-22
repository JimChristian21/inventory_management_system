<script setup>
    import { Head } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Button from "primevue/button";
    import Paginator from '@/Components/Table/Paginator.vue';
    
    const props = defineProps({
        users: Object
    });

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
                        <table class="w-full">
                            <thead>
                                <tr class="border border-black rounded-xl font-bold">
                                    <td class="" v-for="header in headers">
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
                                    <td>{{ user.name }}</td>
                                    <td>Roles</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.created_at }}</td>
                                    <td>
                                        <Button>ACTIONS</Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator 
                            :links="props.users.links" 
                            :from="props.users.from" 
                            :to="props.users.to"
                            :total="props.users.total"
                        />
                    </div>
                </div>
            </div>
            <!-- <DataTable :value="props.users.data" dataKey="id" tableStyle="min-width: 50rem" :totalRecords="props.users.total">
                <Column field="name" header="Name"/>
                <Column field="roles" header="Roles"/>
                <Column field="email" header="Email"/>
                <Column field="created_at" header="Created"/>
                <Column field="actions" header="Actions">
                    Test
                </Column>
                 <Column v-for="user of props.users.data" :key="user.id" :field="user.id" :header="user.id"></Column> -->
            <!-- </DataTable> -->
        </div>
    </AuthenticatedLayout>
</template>