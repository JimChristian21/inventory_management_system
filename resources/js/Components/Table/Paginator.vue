<script setup>
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        from: Number,
        to: Number,
        total: Number,
        links: Array
    });
</script>

<template>
    <div class="flex flex-row justify-between p-2 text-slate-500">
        <div>
            <template v-for="link in props.links">
                <Link class="hover:bg-slate-500 p-2 rounded-lg" :href="link.url ?? '#'" as="button">{{ link.label }}</Link>
            </template>
        </div>
        <div class="flex flex-row text-slate-500">
            <div class="">
                <span>Item per page: </span> 
            </div>
            <span>{{ props.from }} - {{ props.to }} of {{ props.total }}</span>
        </div>
    </div>
</template>