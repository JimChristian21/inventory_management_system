<script setup>

    import { ref } from 'vue';
    import { Link } from '@inertiajs/vue3';
    
    import ItemCreate from './ItemCreate.vue';
    import ItemUpdate from './ItemUpdate.vue';
    import DataTable from '@/Components/Table/DataTable.vue';
    import Column from '@/Components/Table/Column.vue';
    import Row from '@/Components/Table/Row.vue';
    import Modal from '../Modal.vue';
    import Import from '../Import.vue';

    const props = defineProps({
        'items': {
            type: Object,
            required: true
        }
    });

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

    const isCreate = ref(false);
    const isUpdate = ref(false);
    const isImport = ref(false);
    const itemInfo = ref(null);

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

    const setIsImport = (value) => {

        isImport.value = value;
    }

    const isCritical = (quantity, critical_quantity) => {
        
        return quantity <= critical_quantity;
    }
</script>

<template>
    <div>
        <Modal :show="isCreate">
            <div class="w-full h-full bg-white/75 pt-[2%] p-5">
                <ItemCreate 
                    :errors="$page.props.errors.items_create" 
                    @cancelCreate="setIsCreate(false)"
                />
            </div>
        </Modal>

        <Modal :show="isUpdate">
            <div class="w-full h-full bg-white/75 pt-[2%] p-5">
                <ItemUpdate
                    :item="itemInfo" 
                    :errors="$page.props.errors.update" 
                    @cancelUpdate="setIsUpdate(false)"
                />
            </div>
        </Modal>

        <Modal :show="isImport">
            <div class="w-full h-full bg-white/75 pt-[2%] p-5">
                <Import
                    :route="route('item.import')"
                    @cancelImport="setIsImport(false)"
                />
            </div>
        </Modal>
        
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
                        class="bg-slate-400 p-2 rounded-lg hover:cursor-pointer hover:bg-slate-700 hover:text-white" 
                        @click="setIsCreate(true)"
                    >
                        New
                    </button>
                    <Link 
                        :href="route('item.export')" 
                        class="bg-slate-400 p-[.6rem] rounded-lg hover:cursor-pointer ml-2 hover:bg-slate-700 hover:text-white"
                    >
                        Export
                    </Link>
                    <button 
                        class="bg-slate-400 p-2 rounded-lg hover:cursor-pointer ml-2 hover:bg-slate-700 hover:text-white" 
                        @click="setIsImport(true)"
                    >
                        Import
                    </button>
                </div>
            </template>
            <template #body>
                <Row :class="{ 'bg-red-200' : isCritical(item.quantity, item.critical_quantity) }" v-for="item in props.items.data">
                    <Column>{{ item.name }}</Column>
                    <Column>{{ item.description }}</Column>
                    <Column>{{ item.quantity }}</Column>
                    <Column class="flex flex-row gap-2 justify-center">
                        <button 
                            class="cursor-pointer text-orange-400"
                            @click="updateUser(item)"
                        >
                            <font-awesome-icon :icon="['fas', 'pencil-alt']" />
                        </button>
                        <Link 
                            :href="route('item.delete', item.id)"
                            class="cursor-pointer"
                            method="delete"
                            as="button"
                        >
                            <font-awesome-icon :icon="['fas', 'trash']" class="text-red-600" />
                        </Link>
                    </Column>
                </Row>
            </template>
        </DataTable>
    </div>
</template>