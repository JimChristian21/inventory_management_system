<script setup>
    import { Link } from '@inertiajs/vue3';

    const navLink = "w-full text-md p-3 hover:bg-slate-200";
</script>

<template>
    <div class="flex flex-row w-full h-[100vh]">
        <nav class="flex flex-col w-1/4 bg-slate-500">
            <Link
                :class="[navLink]"
                :href="route('dashboard')"
            >
                Dashboard
            </Link>
            <Link 
                :class="[navLink]"
                :href="route('inventory.index')"
            >
                Inventory
            </Link>
            <Link 
                :class="[navLink]"
                :href="route('user.index')"
            >
                User Management
            </Link>
        </nav>
        <div class="w-3/4">
            <header class="h-[30px] bg-slate-300">

            </header>
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
