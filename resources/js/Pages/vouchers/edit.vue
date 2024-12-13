<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Edit Voucher</h1>
        </div>
        <form @submit.prevent="forms.put(route('vouchers.update', props.voucher.id))"
            class="bg-white p-4 rounded-sm flex flex-col gap-4" method="POST">
            <div>
                <p>Code</p>
                <input :class="{ 'border border-red-500': forms.errors.code }" type="text" v-model="forms.code"
                    :disabled="forms.processing">
                <p v-if="forms.errors.code" class="text-red-500">
                    {{ forms.errors.code }}
                </p>
            </div>
            <div>
                <p>Name</p>
                <input :class="{ 'border border-red-500': forms.errors.name }" type="text" v-model="forms.name"
                    :disabled="forms.processing">
                <p v-if="forms.errors.name" class="text-red-500">
                    {{ forms.errors.name }}
                </p>
            </div>
            <div>
                <p>Description</p>
                <input :class="{ 'border border-red-500': forms.errors.description }" type="text"
                    v-model="forms.description" :disabled="forms.processing">
                <p v-if="forms.errors.description" class="text-red-500">
                    {{ forms.errors.description }}
                </p>
            </div>
            <div>
                <p>Type</p>
                <div class="flex gap-2">
                    <div class="flex gap-1">
                        <input type="radio" v-model="forms.type" value="fixed" id="fixed">
                        <label for="fixed"> Fixed </label>
                    </div>
                    <div class="flex gap-1">
                        <input type="radio" v-model="forms.type" value="percentage" id="percentage">
                        <label for="percentage"> Percentage </label>
                    </div>
                </div>
                <p v-if="forms.errors.type" class="text-red-500">
                    {{ forms.errors.type }}
                </p>
            </div>
            <div>
                <p>Value</p>
                <div :class="{ 'border border-red-500': forms.errors.value }"
                    class="flex items-center border rounded-sm">
                    <p v-if="forms.type == 'fixed'" class="pl-2">Rp.</p>
                    <input type="number" class="border-none" placeholder="0" name="value" v-model="forms.value"
                        :disabled="forms.processing">
                    <p v-if="forms.type == 'percentage'" class="pr-2">%</p>
                </div>
                <p v-if="forms.errors.value" class="text-red-500">
                    {{ forms.errors.value }}
                </p>
            </div>
            <div>
                <p>Valid Until</p>
                <div class="flex flex-col justify-center w-max">
                    <div class="flex justify-center items-center gap-2">
                        <VueDatePicker v-model="forms.valid_from" :enable-time-picker="false" placeholder="Valid From"
                            auto-apply />
                        <p>-</p>
                        <VueDatePicker v-model="forms.valid_to" :enable-time-picker="false" placeholder="Valid To"
                            auto-apply />
                    </div>
                    <p class="text-xs mt-1 font-light">Fill blank <span class="font-semibold">valid to</span> time if
                        voucher don't have time periode</p>
                    <p v-if="forms.errors.valid_from" class="text-red-500">
                        {{ forms.errors.valid_from }}
                    </p>
                    <p v-if="forms.errors.valid_to" class="text-red-500">
                        {{ forms.errors.valid_to }}
                    </p>
                </div>
            </div>
            <div>
                <p>Stock</p>
                <div :class="{ 'border border-red-500': forms.errors.stock }"
                    class="flex items-center border rounded-sm">
                    <i class="bx bx-x pl-2"></i>
                    <input :class="{ 'border border-red-500': forms.errors.stock }" type="number" placeholder="0"
                        class="border-none" name="stock" v-model="forms.stock" :disabled="forms.processing">
                </div>
                <p class="text-xs mt-1 font-light">Fill blank to make voucher unlimited use</p>
                <p v-if="forms.errors.stock" class="text-red-500">
                    {{ forms.errors.stock }}
                </p>
            </div>
            <div>
                <p>Active</p>
                <div class="flex gap-2 w-max">
                    <input type="checkbox" v-model="forms.active" id="active">
                    <label for="active"> Active </label>
                </div>
                <p v-if="forms.errors.active" class="text-red-500">
                    {{ forms.errors.active }}
                </p>
            </div>
            <div class="flex justify-between">
                <Link :href="route('vouchers.index')" class="border border-primary py-2 text-sm px-4"
                    :class="{ 'pointer-events-none': forms.processing }">
                Back
                </Link>
                <button class="bg-primary py-2 text-sm px-4" type="submit" :disabled="forms.processing">
                    <i v-if="forms.processing" class="bx bx-loader-alt bx-spin"></i>
                    <p v-else>Update</p>
                </button>
            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import '@vuepic/vue-datepicker/dist/main.css'
import VueDatePicker from '@vuepic/vue-datepicker';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    voucher: Omit<Voucher, "created_at" | "updated_at">
}>();

const forms = useForm<Omit<Voucher, "id" | "used" | "created_at" | "updated_at" | "valid_from_formatted" | "valid_to_formatted">>({
    code: props.voucher.code,
    name: props.voucher.name,
    description: props.voucher.description,
    type: props.voucher.type,
    value: props.voucher.value,
    valid_from: props.voucher.valid_from,
    valid_to: props.voucher.valid_to,
    stock: props.voucher.stock,
    active: props.voucher.active ? true : false
});
</script>