<template>
    <div class="flex flex-col p-4 gap-4 max-h-dvh overflow-y-auto">
       <div class="grid grid-cols-3 grid-rows-1 gap-4">
            <div class="bg-white rounded-sm flex flex-col justify-between p-4 gap-8 text-xl font-medium">
                <div class="flex gap-2 items-center">
                    <button class="bg-primary px-2 py-1 rounded-sm flex justify-center items-center">
                        <i class="bx bx-dollar text-3xl"></i>
                    </button>
                    <p>Total Revenue Today</p>
                </div>
                <p>{{ formatRp(props.total_revenue) }}</p>
            </div>
            <div class="bg-white rounded-sm flex flex-col justify-between p-4 gap-8 text-xl font-medium">
                <div class="flex gap-2 items-center">
                    <button class="bg-primary px-2 py-1 rounded-sm flex justify-center items-center">
                        <i class="bx bx-package text-3xl"></i>
                    </button>
                    <p>Total Items</p>
                </div>
                <p>{{ props.total_items }} Items</p>
            </div>
            <div class="bg-white rounded-sm flex flex-col justify-between p-4 gap-8 text-xl font-medium">
                <div class="flex gap-2 items-center">
                    <button class="bg-primary px-2 py-1 rounded-sm flex justify-center items-center">
                        <i class="bx bx-cart text-3xl"></i>
                    </button>
                    <p>Total Orders</p>
                </div>
                <p> {{ props.total_orders }} Orders</p>
            </div>
        </div>
        <h1>Revenue Chart This Month</h1>
        <div id="chart">
            <VueApexChart type="area" height="350" :options="chartOptions" :series="series" />
        </div>
        <div class="bg-white p-2 rounded-sm flex flex-col gap-2">
            <p class="text-xl">Recent Order</p>
            <table class="w-full table-auto" cellpadding="16">
                <thead class="bg-primary rounded-md">
                    <tr>
                        <th class="font-light rounded-tl-md">No</th>
                        <th class="font-light">Item</th>
                        <th class="font-light">Quantity</th>
                        <th class="font-light">Price</th>
                        <th class="font-light rounded-tr-md">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in props.recent_orders" :key="item.id" class="text-center">
                        <td> {{ i + 1 }} </td>
                        <td>
                            <div class="flex flex-row items-center gap-4">
                                <img :src="`/storage/${item.item.image}`" class="w-24 h-24 aspect-square object-cover rounded-sm" :alt="item.item.name" loading="lazy">
                                {{ item.item.name }}
                            </div>
                         </td>
                        <td> {{ item.qty }} </td>
                        <td> {{ formatRp(item.price) }} </td>
                        <td> {{ formatRp(item.total) }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup lang="ts">
import VueApexChart from 'vue3-apexcharts';

const props = defineProps<{
    total_revenue: number,
    total_items: number,
    total_orders: number,
    recent_orders: DetailItem[],
    charts: Array<[number, number]>
}>();

const series = [{
    name: 'Revenue',
    data: props.charts
}];

const chartOptions = {
    chart: {
        type: 'area',
        stacked: false,
        height: 350,
        zoom: {
            type: 'x',
            enabled: true,
            autoScaleYaxis: true
        },
        toolbar: {
            autoSelected: 'zoom'
        }
    },
    dataLabels: {
        enabled: false
    },
    markers: {
        size: 0,
    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return formatRp(val);
            },
        },
        title: {
            text: 'Revenue'
        },
    },
    fill: {
        colors: ["#181818", "#534523"]
    },
    xaxis: {
        type: 'datetime',
    },
    tooltip: {
        shared: false,
        y: {
        formatter: function (val) {
                return formatRp(val)
            }
        }
    }
}
          
const formatRp = (num : number) => new Intl.NumberFormat("id-ID", {
    currency: "IDR",
    style: "currency",
}).format(num ?? 0);
</script>