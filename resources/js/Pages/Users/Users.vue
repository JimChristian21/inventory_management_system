<script setup>
    import { Head, router } from '@inertiajs/vue3';
    import { reactive, ref, watch } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import UserCreate from '@/Components/User/UserCreate.vue';
    import Button from "primevue/button";
    import Paginator from '@/Components/Table/Paginator.vue';
import { debounce } from 'lodash';
    
    const props = defineProps({
        users: Object
    });

    const search = ref('');
    const sort = reactive({
        column: null,
        order: null,
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

    const sortBy = (column) => {

        if (sort.column !== column) {

            sort.column = column;
            sort.order = 'asc';
        }
        else {

            sort.order = sort.order == 'asc'
                ? 'desc' : 'asc';
        }

        if (column) {

            router.visit(route('user.index'), {
                method: 'get',
                data: {
                    search: search.value,
                    sort: sort
                },
                preserveState: true,
                replace: true
            });
        }
    }

    const setCreate = (value) => {

        create.value = value;
    }

    watch(search, debounce(() => {
        
        router.visit(route('user.index'), {
            method: 'get',
            data: {
                search: search.value,
            },
            preserveState: true,
            replace: truew
        });
    }, 400));
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

        <div v-if="create" class="absolute w-full">
            <div class="w-1/2 mx-auto  h-full  bg-slate-500 p-5 rounded-lg mt-100">
                <UserCreate @cancel="setCreate(false)"/>
            </div>
        </div>

        <div class="py-12 px-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="w-full flex justify-between p-2">
                            <div>
                                <button class="bg-slate-400 p-2 rounded-lg hover:cursor-pointer" @click="setCreate(!create)">
                                    New
                                </button>
                            </div>
                            <div>
                                <input
                                    type="text" 
                                    v-model="search"
                                    class="rounded-lg"
                                    placeholder="Search"
                                />
                            </div>
                        </div>
                        <table class="w-full overflow-scroll">
                            <thead>
                                <tr class="font-bold border-black border-y-2">
                                    <td class="p-2" v-for="header in headers">
                                        <div class="flex flex-row justify-between">
                                            <h2 class="w-1/4">{{ header.name }}</h2>
                                            <button v-if="header.field" @click="sortBy(header.field)">
                                                <font-awesome-icon :icon="['fas', 'sort']"/>
                                            </button>
                                        </div>                                        
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
                                    <td class="p-2">
                                        <template v-for="role in user.roles">
                                            <span>{{ role.name }}</span>
                                        </template>
                                    </td>
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
                            :search="search"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>