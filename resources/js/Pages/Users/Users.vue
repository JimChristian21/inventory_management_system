<script setup>
    import { Head } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import UserCreate from '@/Components/User/UserCreate.vue';
    import DataTable from '@/Components/Table/DataTable.vue';
    import Row from '@/Components/Table/Row.vue';
    import Column from '@/Components/Table/Column.vue';
    
    const props = defineProps({
        users: Object
    });

    const create = ref(false);

    const headers = [
        {
            name: 'Name',
            field: 'name',
            type: 'string'
        },
        {
            name: 'Roles',
            field: null,
            type: 'string'
        },
        {
            name: 'Email',
            field: 'email',
            type: 'string'
        },
        {
            name: 'Created',
            field: 'created_at', 
            type: 'date'
        },
        {
            name: 'Actions',
            field: null,
            type: null
        }
    ];

    const setCreate = (value) => {

        create.value = value;
    }
</script>

<template>
    <Head title="User Management" />
    
    <div v-if="create" class="absolute w-full h-full bg-black/75 pt-[2%]">
        <div class="w-1/2 h-100 mx-auto my-auto bg-white p-5 rounded-lg">
            <UserCreate :errors="$page.props.errors.create" @cancel="setCreate(false)"/>
        </div>
    </div>

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
                    <DataTable
                        :route="route('user.index')"
                        :headers="headers"
                        :paginatorOptions="{
                            links: props.users.links,
                            perPage: props.users.per_page,
                            from: props.users.from,
                            to: props.users.to,
                            total: props.users.total
                        }"
                    >
                        <template #headerActions>
                            <div>
                                <button class="bg-slate-400 p-2 rounded-lg hover:cursor-pointer" @click="setCreate(!create)">
                                    New
                                </button>
                            </div>
                        </template>
                        <template #body>
                            <Row v-for="user in props.users.data">
                                <Column>{{ user.name }}</Column>
                                <Column>
                                    <div v-for="role in user.roles">
                                        <span>{{ role.name }}</span>
                                    </div>
                                </Column>
                                <Column>{{ user.email }}</Column>
                                <Column>{{ user.created_at }}</Column>
                                <Column>ACTION</Column>
                            </Row>
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>