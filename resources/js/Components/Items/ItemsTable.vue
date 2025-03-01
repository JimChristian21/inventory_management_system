<script setup>

    import { onMounted, ref } from 'vue';
    import { Link, router } from '@inertiajs/vue3';
    
    import ItemCreate from './ItemCreate.vue';
    import ItemUpdate from './ItemUpdate.vue';
    import DataTable from '@/Components/Table/DataTable.vue';
    import Column from '@/Components/Table/Column.vue';
    import Row from '@/Components/Table/Row.vue';

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

</script>

<template>
    <div>
        <div v-if="isCreate" class="absolute w-full h-full bg-black/75 pt-[2%]">
            <div class="w-1/2 h-100 mx-auto my-auto bg-white p-5 rounded-lg">
                <ItemCreate :errors="$page.props.errors.items_create" @cancelCreate="setIsCreate(false)"/>
            </div>
        </div>

        <div v-if="isUpdate" class="absolute w-full h-full bg-black/75 pt-[2%]">
            <div class="w-1/2 h-100 mx-auto my-auto bg-white p-5 rounded-lg">
                <ItemUpdate
                    :item="itemInfo" 
                    :errors="$page.props.errors.update" 
                    @cancelUpdate="setIsUpdate(false)"
                />
            </div>
        </div>
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