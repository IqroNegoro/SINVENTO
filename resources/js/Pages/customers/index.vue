<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Customers</h1>
            <Link :href="route('customers.create')"
                class="px-2 py-1 flex justify-center items-center bg-primary rounded-md text-white">
            <i class="bx bx-plus text-2xl"></i>
            </Link>
        </div>
        <div class="flex justify-between items-center bg-transparent">
            <div>
                <select v-model="sort" class="bg-transparent appearance-auto" @change.prevent="router.get('', {
                    sort
                })">
                    <option value="">No Sort</option>
                    <option value="code">Code</option>
                    <option value="name">Name</option>
                    <option value="phone">Phone</option>
                    <option value="visit">Visit</option>
                    <option value="total">Total Spend</option>
                </select>
            </div>
            <div class="flex flex-row justify-center items-center border">
                <input @keydown.enter="router.get('', { search })" type="text" class="bg-transparent border-0" placeholder="Search..." v-model="search">
                <button class="h-full flex justify-center items-center p-3 bg-primary"
                    @click.prevent="router.get('', { search })">
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </div>
        <div class="bg-white">
            <table class="w-full table-auto" cellpadding="16">
                <thead class="bg-primary text-white rounded-md">
                    <tr>
                        <th class="font-light rounded-tl-md">No</th>
                        <th class="font-light">Code</th>
                        <th class="font-light">Name</th>
                        <th class="font-light">Phone</th>
                        <th class="font-light">Visit</th>
                        <th class="font-light">Total Spend</th>
                        <th class="font-light rounded-tr-md">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, i) in customers.data" :key="customer.id" class="text-center">
                        <td> {{ i + 1 }} </td>
                        <td> {{ customer.code }} </td>
                        <td> {{ customer.name }} </td>
                        <td> {{ customer.phone }} </td>
                        <td> {{ customer.visit }} </td>
                        <td> {{ formatRp(customer.total) }} </td>
                        <td class="flex justify-center items-center gap-2">
                            <Link :href="route('customers.edit', customer.id)">
                            <i class="bx bx-edit"></i>
                            </Link>
                            <button @click="router.delete(route('customers.destroy', customer.id))">
                                <i class="bx bxs-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div
            class="flex justify-between px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase">
            <span class="flex items-center col-span-3">
                Showing {{ customers.from }}-{{ customers.to }} of {{ customers.total }}
            </span>
            <span class="col-span-2"></span>
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <!-- <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                            aria-label="Previous">
                            <i class="bx bx-chevron-left"></i>
                        </button> -->
                        <li v-for="link in customers.links" :key="link.label">
                            <Link v-if="link.url != null" class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple" :class="{'bg-white text-black': link.active}" v-html="link.label" :href="link.url"></Link>
                        </li>
                        <!-- <li>
                            <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                aria-label="Next">
                                <i class="bx bx-chevron-right"></i>
                            </button>
                        </li> -->
                    </ul>
                </nav>
            </span>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { ref, Ref } from 'vue';

const props = defineProps<{
    customers: {
        from: number,
        to: number,
        total: number,
        data: Customer[]
        links: Link[],
    }
}>();

const sort: Ref<null | string | "code" | "name" | "visit" | "total"> = ref(new URLSearchParams(window.location.search).get("sort") || "");
const search: Ref<null | string> = ref(new URLSearchParams(window.location.search).get("search"));

const formatRp = (num : number) => new Intl.NumberFormat("id-ID", {
    currency: "IDR",
    style: "currency",
}).format(num);
</script>