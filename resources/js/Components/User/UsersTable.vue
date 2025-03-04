<script setup>
    
    import { ref } from 'vue';
    import UserCreate from './UserCreate.vue';
    import UserUpdate from './UserUpdate.vue';
    import DataTable from '@/Components/Table/DataTable.vue';
    import Row from '@/Components/Table/Row.vue';
    import Column from '@/Components/Table/Column.vue';
    import Modal from '../Modal.vue';
    import { Link } from '@inertiajs/vue3';
    
    const props = defineProps({
        users: Object
    });

    const isCreate = ref(false);
    const isUpdate = ref(false);
    const userInfo = ref(null);

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

    const updateUser = (data) => {

        userInfo.value = data;
        setIsUpdate(true);
    }

    const setIsCreate = (value) => {

        isCreate.value = value;
    }

    const setIsUpdate = (value) => {

        isUpdate.value = value;
    }
</script>

<template>
    <div>
        <Modal :show="isCreate">
            <div class="w-full h-full bg-white/75 pt-[2%] p-5">
                <UserCreate 
                    :errors="$page.props.errors.create" 
                    @cancelCreate="setIsCreate(false)"
                />
            </div>
        </Modal>
        
        <Modal :show="isUpdate">
            <div class="w-full h-full bg-white/75 pt-[2%] p-5">
                <UserUpdate
                    :user="userInfo" 
                    :errors="$page.props.errors.update" 
                    @cancelUpdate="setIsUpdate(false)"
                />
            </div>
        </Modal>

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
                    <button class="bg-slate-400 p-2 rounded-lg hover:cursor-pointer" @click="setIsCreate(!create)">
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
                    <Column class="flex flex-row gap-2 justify-center">
                        <button 
                            class="cursor-pointer text-orange-400"
                            @click="updateUser(user)"
                        >
                            <font-awesome-icon :icon="['fas', 'pencil-alt']" />
                        </button>
                        <Link 
                            :href="route('user.delete', user.id)"
                            class="cursor-pointer"
                            method="delete"
                        >
                            <font-awesome-icon :icon="['fas', 'trash']" class="text-red-600" />
                        </Link>
                    </Column>
                </Row>
            </template>
        </DataTable>
    </div>
</template>