<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Sales</h1>
        </div>
        <div class="flex justify-between items-center bg-transparent">
            <div>
                <select v-model="sort" class="bg-transparent appearance-auto" @change.prevent="router.get('', {
                    sort
                })">
                    <option value="">No Sort</option>
                    <option value="customer">Customer</option>
                    <option value="created_at">Date</option>
                    <option value="total">Total</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button @click="menuExportPDF = true"
                    class="bg-red-500 px-3 py-1 rounded-sm flex gap-2 items-center text-white font-medium">
                    <i class='bx bxs-file-pdf'></i>
                    PDF
                </button>
                <button @click="menuExportExcel = true"
                    class="bg-green-500 px-3 py-1 rounded-sm flex gap-2 items-center text-white font-medium">
                    <i class='bx bxs-file-blank'></i>
                    Excel
                </button>
            </div>
        </div>
        <div class="bg-white">
            <table class="w-full table-auto" cellpadding="16">
                <thead class="bg-primary text-white rounded-md">
                    <tr>
                        <th class="font-light rounded-tl-md">No</th>
                        <th class="font-light">Customer</th>
                        <th class="font-light">Date</th>
                        <th class="font-light">Total</th>
                        <th class="font-light">Detail</th>
                        <th class="font-light rounded-tr-md">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sale, i) in sales.data" :key="sale.id" class="text-center">
                        <td> {{ i + 1 }} </td>
                        <td> {{ sale.customer?.name ?? "-" }} </td>
                        <td> {{ moment(sale.created_at).format("MMM D YYYY, h:mm:ss a") }} </td>
                        <td> {{ formatRp(sale.total) }} </td>
                        <td>
                            <Link :href="route('sales.show', sale.id)" class="rounded-sm bg-primary py-2 px-4">
                            Detail
                            </Link>
                        </td>
                        <td class="flex justify-center items-center gap-2">
                            <button @click="router.delete(route('sales.destroy', sale.id))">
                                <i class="bx bxs-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase">
            <span class="flex items-center col-span-3">
                Showing {{ sales.from }}-{{ sales.to }} of {{ sales.total }}
            </span>
            <span class="col-span-2"></span>
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <!-- <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                            aria-label="Previous">
                            <i class="bx bx-chevron-left"></i>
                        </button> -->
                        <li v-for="link in sales.links" :key="link.label">
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
        <div v-if="menuExportPDF" @click.self="menuExportPDF = false"
            class="flex justify-center items-center fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/30 w-full h-full">
            <div class="bg-white rounded-sm w-96 p-4 flex flex-col justify-center items-center gap-4">
                <p class="text-2xl">Generate Report PDF</p>
                <div class="w-full flex flex-col gap-2">
                    <div>
                        <p class="text-lg">Date</p>
                        <VueDatePicker
                            :class="{ 'border border-red-500': $page.props.errors?.startDate || $page.props.errors?.endDate }"
                            v-model="dates" placeholder="Select Dates" range position="center"
                            :enable-time-picker="false" auto-apply />
                        <p class="text-red-500 text-sm"
                            v-if="$page.props.errors?.startDate || $page.props.errors?.endDate"> Please select the dates
                        </p>
                    </div>
                    <button :disabled="!(dates?.[0] && dates?.[1]) || state" @click="router.get(route('sales.report.pdf'), {
                        startDate: dates[0],
                        endDate: dates[1]
                    }, {
                        preserveState: true,
                        onStart: () => state = true,
                        onFinish: () => state = false
                    })" class="bg-primary py-2 px-1 flex justify-center items-center">
                        <i v-if="state" class="bx bx-loader-alt bx-spin"></i>
                        <p v-else>
                            Generate Report PDF
                        </p>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="menuExportExcel" @click.self="menuExportExcel = false"
            class="flex justify-center items-center fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/30 w-full h-full">
            <div class="bg-white rounded-sm w-96 p-4 flex flex-col justify-center items-center gap-4">
                <p class="text-2xl">Generate Report Excel</p>
                <div class="w-full flex flex-col gap-2">
                    <div>
                        <p class="text-lg">Date</p>
                        <VueDatePicker
                            :class="{ 'border border-red-500': $page.props.errors?.startDate || $page.props.errors?.endDate }"
                            v-model="dates" placeholder="Select Dates" range position="center"
                            :enable-time-picker="false" auto-apply />
                        <p class="text-red-500 text-sm"
                            v-if="$page.props.errors?.startDate || $page.props.errors?.endDate"> Please select the dates
                        </p>
                    </div>
                    <a :disabled="!(dates?.[0] && dates?.[1]) || state" :href="route('sales.report.excel', {
                        _query: {
                            startDate: dates[0],
                            endDate: dates[1]
                        },
                    })" class="bg-primary py-2 px-1 flex justify-center items-center">
                        <i v-if="state" class="bx bx-loader-alt bx-spin"></i>
                        <p v-else>
                            Generate Report Excel
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import moment from "moment";
import { Ref, ref, watch } from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import VueDatePicker, { DatePickerInstance } from '@vuepic/vue-datepicker';

const menuExportPDF: Ref<boolean> = ref(false);
const menuExportExcel: Ref<boolean> = ref(false);
const state: Ref<boolean> = ref(false);
const dates: Ref<Array<[Date, Date]>> = ref([]);

const sort: Ref<null | string | "date" | "total"> = ref(new URLSearchParams(window.location.search).get("sort") || "");

const props = defineProps<{
    sales: {
        from: number,
        to: number,
        total: number,
        data: Sale[]
        links: Link[],
    }
}>();

watch(dates, () => usePage().props.errors = {})

const formatRp = (num: number) => new Intl.NumberFormat("id-ID", {
    currency: "IDR",
    style: "currency",
}).format(num);
</script>