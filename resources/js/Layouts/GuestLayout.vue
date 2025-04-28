<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    loginImg: {
        type: String
    }
});
</script>

<template>
    <div
        class="flex w-full h-100vh min-h-screen flex-row items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <div class="w-1/4 p-10">
            <slot />
        </div>

        <div class="w-3/4 bg-generic_img">
            <img class="w-[50%] border-none" :src="loginImg"/>
        </div>
    </div>
</template>
