<script setup>
    import { Link, router } from '@inertiajs/vue3';
    import { ref, watch } from 'vue';

    const props = defineProps({
        route: {
            type: String,
            default: '#',
        },
        from: {
            type: Number,
            default: 0
        },
        to: {
            type: Number,
            default: 0
        },
        links: {
            type: Array,
            default: [],
        },
        perPage: {
            type: Number,
            default: 10
        },
        total: {
            type: Number,
            default: 0
        },
    });

    const itemsPerPage = ref(props.perPage);

    const getLinkName = (name) => {

        let ret = name;

        if (name.includes('Previous')) {

            ret = 'Prev';
        } 
        else if (name.includes('Next')) {

            ret = 'Next';
        }

        return ret;
    }

    watch(itemsPerPage, () => {

        router.visit(props.route, {
            method: 'get',
            data: {
                perPage: itemsPerPage.value
            },
            preserveState: true,
            replace: true
        });
    });
</script>

<template>
    <div class="flex flex-row justify-between p-2 text-slate-500">
        <div>
            <template v-if="props.links">
                <template v-for="link in props.links">
                    <Link 
                        class="p-2 rounded-lg" 
                        :class="{ 
                            'bg-black text-white' : link.active, 
                            'hover:bg-none' : !link.url,
                            'hover:bg-slate-700 hover:text-white' : !link.active && link.url
                        }"
                        :href="link.url ?? '#'" 
                        as="button" 
                        :disabled="!link.url"
                        preserve-state
                    >
                        {{ getLinkName(link.label) }}
                    </Link>
                </template>
            </template>
        </div>
        <div class="flex flex-row text-slate-500">
            <div>
                <span>Item per page: </span> 
                <select class="rounded-lg" v-model="itemsPerPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
            </div>
            <div class="content-center p-2">
                <span>{{ props.from ?? 0 }} - {{ props.to ?? 0 }} of {{ props.total }}</span>
            </div>
        </div>
    </div>
</template>