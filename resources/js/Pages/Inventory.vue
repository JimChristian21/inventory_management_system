<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import ItemCreate from '@/Components/Item/ItemCreate.vue';
    import ItemUpdate from '@/Components/Item/ItemUpdate.vue';
    import DataTable from '@/Components/Table/DataTable.vue';
    import Row from '@/Components/Table/Row.vue';
    import Column from '@/Components/Table/Column.vue';
    
    const props = defineProps({
        items: {
            type: Object
        }
    });

    const isCreate = ref(false);
    const isUpdate = ref(false);
    const itemInfo = ref(null);

    const headers = [
        {
            name: 'Name',
            field: 'name',
            type: 'string'
        },
        {
            name: 'Description',
            field: 'description',
            type: 'string'
        },
        {
            name: 'Quantity',
            field: 'quantity',
            type: 'int'
        },
        {
            name: 'Actions',
            field: null,
            type: null
        }
    ];

    const updateUser = (data) => {

        itemInfo.value = data;
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
    <Head title="Inventory" />
    
    <div v-if="isCreate" class="absolute w-full h-full bg-black/75 pt-[2%]">
        <div class="w-1/2 h-100 mx-auto my-auto bg-white p-5 rounded-lg">
            <ItemCreate :errors="$page.props.errors.create" @cancelCreate="setIsCreate(false)"/>
        </div>
    </div>

    <div v-if="isUpdate" class="absolute w-full h-full bg-black/75 pt-[2%]">
        <div class="w-1/2 h-100 mx-auto my-auto bg-white p-5 rounded-lg">
            <ItemUpdate
                :item="itemInfo" 
                :errors="$page.props.errors.update" 
                @cancelUpdate="setIsUpdate(false)"/>
        </div>
    </div>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                <font-awesome-icon :icon="['fas', 'users']" /> 
                Inventory
            </h2>
        </template>

        <div class="py-12 px-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <DataTable
                        :route="route('inventory.index')"
                        :headers="headers"
                        :paginatorOptions="{
                            links: props.items.links,
                            perPage: props.items.per_page,
                            from: props.items.from,
                            to: props.items.to,
                            total: props.items.total
                        }"
                    >
                        <template #headerActions>
                            <div>
                                <button 
                                    class="bg-slate-400 p-2 rounded-lg hover:cursor-pointer" 
                                    @click="setIsCreate(true)"
                                >
                                    New
                                </button>
                            </div>
                        </template>
                        <template #body>
                            <Row v-for="item in props.items.data">
                                <Column>{{ item.name }}</Column>
                                <Column>{{ item.description }}</Column>
                                <Column>{{ item.quantity }}</Column>
                                <Column class="flex flex-row gap-2 justify-center">
                                    ACTIONS
                                    <button 
                                        class="cursor-pointer text-orange-400"
                                        @click="updateUser(item)"
                                    >
                                        <font-awesome-icon :icon="['fas', 'pencil-alt']" />
                                    </button>
                                    <!-- <Link 
                                        :href="route('user.delete', user.id)"
                                        class="cursor-pointer"
                                        method="post"
                                    >
                                        <font-awesome-icon :icon="['fas', 'trash']" class="text-red-600" />
                                    </Link> -->
                                </Column>
                            </Row>
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>