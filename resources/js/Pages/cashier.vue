<template>
    <div class="flex flex-col gap-4 h-full overflow-hidden">
        <h1 class="font-semibold text-3xl">Cashier</h1>
        <div class="flex gap-2 w-full h-full overflow-y-auto overflow-hidden">
            <div
                class="grid grid-flow-row grid-cols-4 p-4 gap-4 items-start justify-start bg-white overflow-y-auto w-full h-full">
                <button v-for="item in props.items" :key="item.id" @click="handleAddItem(item)"
                    class="flex flex-col justify-start gap-2">
                    <img :src="`/storage/${item.image}`" :alt="item.name"
                        class="w-32 rounded-sm aspect-square object-cover object-center"
                        :class="{ 'grayscale': item.stock == 0 }">
                    <p class="font-semibold text-sm text-left"> {{ item.name }} </p>
                    <p class="font-medium text-xs">{{ formatRp(item.sell_price) }} </p>
                    <p class="font-light text-xs">x{{ item.stock }}</p>
                </button>
            </div>
            <form @submit.prevent="forms.post(route('cashier.store'), {
                onSuccess: () => forms.reset()
            })" class="bg-white flex flex-col justify-between w-1/2 max-h-full">
                <table class="table-fixed" cellpadding="16">
                    <thead class="bg-primary text-white rounded-md sticky top-0 z-1">
                        <tr class="text-sm">
                            <th class="font-light rounded-tl-md">Item</th>
                            <th class="font-light">Qty</th>
                            <th class="font-light">Price</th>
                            <th class="font-light">Total</th>
                            <th class="font-light rounded-tr-md">
                                <i class="bx bx-trash"></i>
                            </th>
                        </tr>
                    </thead>
                </table>
                <div class="w-full h-full overflow-y-auto">
                    <template v-if="forms.items.length">
                        <table class="table-fixed" cellpadding="16">
                            <tbody>
                                <tr v-for="item in forms.items" :key="item.id" class="text-center text-xs">
                                    <td> {{ item.name }} </td>
                                    <td>
                                        <input type="tel" :value="item.qty" class="w-10"
                                            @input="handleQty($event, item)">
                                    </td>
                                    <td> {{ formatRp(item.sell_price) }} </td>
                                    <td> {{ formatRp(item.qty * item.sell_price!) }} </td>
                                    <td>
                                        <div class="flex justify-center items-center gap-2">
                                            <button @click="handleDelete(item)"
                                                class="flex justify-center items-center">
                                                <i class="bx bxs-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <p v-else class="text-center mt-4">No Items Added</p>
                </div>
                <div class="flex flex-col gap-2 p-2 text-sm">
                    <div class="flex justify-between whitespace-nowrap">
                        <p class="text-slate-500">Total Items</p>
                        <p> {{ forms.items.length }} Items</p>
                    </div>
                    <div class="flex justify-between whitespace-nowrap">
                        <p class="text-slate-500">Subtotal</p>
                        <p>{{ formatRp(subtotal) }} </p>
                    </div>
                    <div class="flex justify-between whitespace-nowrap">
                        <p class="text-slate-500">Total</p>
                        <p>{{ total >= 0 ? formatRp(total) : formatRp(0) }} </p>
                    </div>
                    <div>
                        <p>Customer ID</p>
                        <input type="text" class="border-slate-500 p-1" placeholder="Customer ID">
                    </div>
                    <div>
                        <p>Voucher</p>
                        <select v-model="forms.voucher_id" name="" id="">
                            <option :value="null">Select Voucher</option>
                            <option v-for="voucher in vouchers" :key="voucher.id" :value="voucher.id"> {{ voucher.name
                                }} | {{
                                    `${voucher.type == 'fixed' ? formatRp(voucher.value) : voucher.value + "%"}` }}
                            </option>
                        </select>
                    </div>
                    <div class="flex gap-2 w-full">
                        <button @click="forms.reset()" type="reset" class="border border-primary py-2 w-full"
                            :disabled="forms.processing || !forms.items.length">
                            Cancel
                        </button>
                        <button class="bg-primary py-2 w-full flex justify-center items-center" type="submit"
                            :disabled="forms.processing || !forms.items.length">
                            <i class="bx bx-loader-alt bx-spin" v-if="forms.processing"></i>
                            <p v-else>
                                Pay
                            </p>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, InputHTMLAttributes } from 'vue';

const props = defineProps<{
    items: Item[],
    vouchers: Voucher[]
}>();

const forms = useForm<{
    items: (Item & {
        qty: number,
    })[],
    voucher_id: null
}>({
    items: [],
    voucher_id: null
});

const subtotal = computed(() => forms.items.reduce((prev, next) => prev += next.qty * next.sell_price!, 0))
const total = computed(() => {
    let voucher = props.vouchers.find(v => v.id == forms.voucher_id);

    return voucher ? forms.items.reduce((prev, next) => prev += next.qty * next.sell_price!, 0) - (voucher.type == 'fixed' ? voucher.value : subtotal.value * voucher.value / 100) : subtotal.value
});

const handleAddItem = (item: Item) => {
    const exist = forms.items.findIndex(v => v.id == item.id) >= 0;
    const propItem = props.items.find(v => v.id == item.id);
    if (propItem!.stock > 0) {
        if (exist) {
            forms.items.find(v => v.id == item.id)!.qty += 1;
        } else {
            forms.items.push({
                ...item,
                qty: 1,
            });
        }
        propItem!.stock -= 1;
    }
}

const handleQty = (e: Event, item: Item & { qty: number }) => {
    let target = e.currentTarget as InputHTMLAttributes;
    const propItem = props.items.find(v => v.id == item.id);
    const qty = target.value;
    if (propItem!.stock + item.qty >= qty) {
        propItem!.stock += item.qty;
        item.qty = +qty;
        propItem!.stock -= item.qty;
    } else {
        item.qty += propItem!.stock;
        propItem!.stock = 0;
        target.value = item.qty;
    }
}

const handleDelete = (item: Item & { qty: number }) => {
    props.items.find(v => v.id == item.id)!.stock += item.qty;
    forms.items = forms.items.filter(v => v.id != item.id);
}

const formatRp = (num: number) => new Intl.NumberFormat("id-ID", {
    currency: "IDR",
    style: "currency",
}).format(num);

</script>