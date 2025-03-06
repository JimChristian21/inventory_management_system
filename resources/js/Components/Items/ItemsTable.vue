<script setup>

    import { ref } from 'vue';
    import { Link } from '@inertiajs/vue3';
    
    import ItemCreate from './ItemCreate.vue';
    import ItemUpdate from './ItemUpdate.vue';
    import DataTable from '@/Components/Table/DataTable.vue';
    import Column from '@/Components/Table/Column.vue';
    import Row from '@/Components/Table/Row.vue';
    import Modal from '../Modal.vue';

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
                    <Link 
                        :link="route('item.export')" 
                        method="get"
                        as="button"
                        class="bg-slate-400 p-2 rounded-lg hover:cursor-pointer"
                    >
                        Export
                    </Link>
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