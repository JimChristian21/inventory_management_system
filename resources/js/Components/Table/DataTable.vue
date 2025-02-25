<script setup>

import { debounce } from 'lodash';
import { reactive, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Paginator from './Paginator.vue';

const props = defineProps({
    headers: {
        type: Array,
        default: []
    },
    paginatorOptions: {
        type: Object,
        required: true
    },
    route: {
        type: String,
        required: true
    }
});

const search = ref('');
const sort = reactive({
    column: null,
    order: null,
});

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

        router.visit(props.route, {
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

watch(search, debounce(() => {
    
    router.visit(props.route, {
        method: 'get',
        data: {
            search: search.value,
        },
        preserveState: true,
        replace: true
    });
}, 400));

</script>

<template>
    <div class="p-6 text-gray-900">
        <div class="w-full flex justify-between p-2">
            <div>
                <slot name="headerActions"></slot>
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
                    <td class="p-2" v-for="header in props.headers">
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
                <slot name="body"></slot>
            </tbody>
        </table>
        <Paginator
            :route="props.route"
            :links="props.paginatorOptions.links" 
            :perPage="props.paginatorOptions.per_page"
            :from="props.paginatorOptions.from"
            :to="props.paginatorOptions.to"
            :total="props.paginatorOptions.total"
        />
    </div>
</template>