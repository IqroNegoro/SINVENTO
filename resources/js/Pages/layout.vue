<template>
    <div class="flex overflow-hidden">
        <nav :class="{'w-96': lock, 'w-[calc(23px*4)]': !lock}" class="hover:w-96 group transition-[width] duration-300 p-4 flex flex-col gap-16 overflow-clip">
            <div class="w-full flex justify-between h-max relative">
                <h1 class="font-medium text-2xl" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">Dashboard</h1>
                <button class="w-max absolute top-1/2 -translate-y-1/2 group-hover:translate-x-0 group-hover:right-0 flex justify-center items-center text-xl hover:bg-primary hover:text-white transition-all duration-150 p-2 rounded-full" :class="{'bg-primary right-0 translate-x-0': lock, 'right-1/2 translate-x-1/2': !lock}" @click="lock = !lock">
                    <i :class="{'rotate-180': lock}" class="bx bx-chevrons-right group-hover:rotate-180 duration-300 transition-transform"></i>
                </button>
            </div>
            <div class="flex flex-col gap-2">
                <Link :href="route('dashboard')" class="link-btn" :class="{'link-active': $page.url.startsWith('/') && $page.url.endsWith('/')}">
                    <i class="bx bxs-dashboard"></i>
                    <p class="whitespace-nowrap" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">Dashboard</p>
                </Link>
                <Link :href="route('user.index')" class="link-btn" :class="{'link-active': $page.url.startsWith('/user')}">
                    <i class="bx bx-user"></i>
                    <p class="whitespace-nowrap" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">User</p>
                </Link>
                <Link :href="route('categories.index')" class="link-btn" :class="{'link-active': $page.url.startsWith('/categories')}">
                    <i class="bx bx-list-ul"></i>
                    <p class="whitespace-nowrap" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">Categories</p>
                </Link>
                <Link :href="route('items.index')" class="link-btn" :class="{'link-active': $page.url.startsWith('/items')}">
                    <i class="bx bx-package"></i>
                    <p class="whitespace-nowrap" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">Items</p>
                </Link>
                <Link :href="route('sales.index')" class="link-btn" :class="{'link-active': $page.url.startsWith('/sales')}">
                    <i class="bx bx-dollar"></i>
                    <p class="whitespace-nowrap" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">Sales</p>
                </Link>
                <Link :href="route('cashier.index')" class="link-btn" :class="{'link-active': $page.url.startsWith('/cashier')}">
                    <i class="bx bx-cart"></i>
                    <p class="whitespace-nowrap" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">Cashier</p>
                </Link>
                <button @click="router.delete(route('logout'))" class="link-btn w-full">
                    <i class="bx bx-log-out"></i>
                    <p class="whitespace-nowrap" :class="{'opacity-0 group-hover:opacity-100': !lock, 'opacity-100': lock}">Log Out</p>
                </button>
            </div>
        </nav>
        <div class="bg-[#F6F6F6] w-full p-4 h-dvh overflow-y-auto">
            <slot  />
        </div>
        <div v-if="$page.props.error || $page.props.success" class="fixed right-4 top-4 shadow-sm bg-primary py-2 px-4 rounded-sm flex items-center gap-4 cursor-pointer" @click="() => {$page.props.success = null; $page.props.error = null}">
            <p> {{ $page.props.error || $page.props.success }} </p>
            <button>
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Ref, ref } from 'vue';

const lock : Ref<boolean> = ref(false);

</script>