<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Vouchers</h1>
            <Link :href="route('vouchers.create')"
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
                </select>
            </div>
            <div class="flex flex-row justify-center items-center border">
                <input @keydown.enter="router.get('', { search })" type="text" class="bg-transparent border-0"
                    placeholder="Search..." v-model="search">
                <button class="h-full flex justify-center items-center p-3 bg-primary"
                    @click.prevent="router.get('', { search })">
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </div>
        <div class="bg-white">
            <table class="w-full table-auto text-sm" cellpadding="16">
                <thead class="bg-primary text-white rounded-md">
                    <tr>
                        <th class="font-light rounded-tl-md">No</th>
                        <th class="font-light">Code</th>
                        <th class="font-light">Name</th>
                        <th class="font-light">Type</th>
                        <th class="font-light">Value</th>
                        <th class="font-light">Valid From</th>
                        <th class="font-light">Stock</th>
                        <th class="font-light">Used</th>
                        <th class="font-light">Active</th>
                        <th class="font-light rounded-tr-md">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(voucher, i) in props.vouchers.data" :key="voucher.id" class="text-center">
                        <td> {{ i + 1 }} </td>
                        <td> {{ voucher.code }} </td>
                        <td class="whitespace-nowrap max-w-64 relative">
                            <p class="truncate peer">
                                {{ voucher.name }}
                            </p>
                            <div class="tooltips">
                                <div>
                                    <p class="font-medium">Voucher Name</p>
                                    <p class="text-sm text-light">
                                        {{ voucher.name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="font-medium">Voucher Description</p>
                                    <p class="text-sm text-light">
                                        {{ voucher.description }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="first-letter:uppercase"> {{ voucher.type }} </td>
                        <td> {{ voucher.type == 'percentage' ? `${voucher.value}%` : formatRp(voucher.value) }} </td>
                        <td> {{ voucher.valid_from }} {{ voucher.valid_to ? `- ${voucher.valid_to}` : "" }} </td>
                        <td> {{ voucher.stock ? voucher.stock : "-" }} </td>
                        <td> {{ voucher.used }} </td>
                        <td :class="{ 'text-green-500': voucher.active }"> {{ voucher.active ? 'Active' : 'Not Active' }}
                        </td>
                        <td class="flex justify-center items-center gap-2">
                            <Link :href="route('vouchers.edit', voucher.id)">
                            <i class="bx bx-edit"></i>
                            </Link>
                            <button @click="router.delete(route('vouchers.destroy', voucher.id))">
                                <i class="bx bxs-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase">
            <span class="flex items-center col-span-3">
                Showing {{ vouchers.from }}-{{ vouchers.to }} of {{ vouchers.total }}
            </span>
            <span class="col-span-2"></span>
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <!-- <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                            aria-label="Previous">
                            <i class="bx bx-chevron-left"></i>
                        </button> -->
                        <li v-for="link in vouchers.links" :key="link.label">
                            <Link v-if="link.url != null"
                                class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                                :class="{ 'bg-white text-black': link.active }" v-html="link.label" :href="link.url">
                            </Link>
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
    vouchers: {
        from: number,
        to: number,
        total: number,
        data: Voucher[]
        links: Link[],
    }
}>();

const sort: Ref<null | string | "code" | "name"> = ref(new URLSearchParams(window.location.search).get("sort") || "");
const search: Ref<null | string> = ref(new URLSearchParams(window.location.search).get("search"));

const formatRp = (num: number) => new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
}).format(num);
</script>