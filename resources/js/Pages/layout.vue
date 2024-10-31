<template>
    <div class="flex flex-row w-full h-dvh">
        <div class="min-w-72 p-4 flex flex-col gap-16">
            <div class="w-full flex justify-between h-max">
                <h1 class="font-medium text-2xl">Dashboard</h1>
                <button class="flex justify-center items-center text-xl hover:bg-primary hover:text-white transition-colors duration-150 p-2 rounded-full">
                    <i class="bx bx-chevrons-left"></i>
                </button>
            </div>
            <div class="flex flex-col gap-2">
                <Link :href="route('dashboard')" class="flex justify-start font-medium text-xl items-center hover:active p-4 gap-4 rounded-sm" :class="{'active': $page.url.startsWith('/dashboard')}">
                    <i class="bx bxs-dashboard"></i>
                    <p>Dashboard</p>
                </Link>
                <Link :href="route('user.index')" class="flex justify-start font-medium text-xl items-center p-4 gap-4 rounded-sm hover:active" :class="{'active': $page.url.startsWith('/user')}">
                    <i class="bx bx-user"></i>
                    <p>User</p>
                </Link>
                <Link :href="route('items.index')" class="flex justify-start font-medium text-xl items-center p-4 gap-4 rounded-sm hover:active" :class="{'active': $page.url.startsWith('/items')}">
                    <i class="bx bx-package"></i>
                    <p>Items</p>
                </Link>
                <Link :href="route('categories.index')" class="flex justify-start font-medium text-xl items-center p-4 gap-4 rounded-sm hover:active" :class="{'active': $page.url.startsWith('/categories')}">
                    <i class="bx bx-list-ul"></i>
                    <p>Categories</p>
                </Link>
                <Link :href="route('sales.index')" class="flex justify-start font-medium text-xl items-center p-4 gap-4 rounded-sm hover:active" :class="{'active': $page.url.startsWith('/sales')}">
                    <i class="bx bx-dollar"></i>
                    <p>Sales</p>
                </Link>
                <Link :href="route('cashier.index')" class="flex justify-start font-medium text-xl items-center p-4 gap-4 rounded-sm hover:active" :class="{'active': $page.url.startsWith('/cashier')}">
                    <i class="bx bx-cart"></i>
                    <p>Cashier</p>
                </Link>
                <button @click="router.delete(route('logout'))" class="flex justify-start font-medium text-xl items-center p-4 gap-4 rounded-sm hover:active w-full">
                    <i class="bx bx-log-out"></i>
                    <p>Log Out</p>
                </button>
            </div>
        </div>
        <div class="bg-[#F6F6F6] w-full">
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
<script setup>
import { Link, router } from '@inertiajs/vue3';

</script>