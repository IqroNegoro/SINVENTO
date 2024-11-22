<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">Update Customer</h1>
        </div>
        <form @submit.prevent="forms.put(route('customers.update', customer.id))"
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
                <p>Phone</p>
                <input :class="{ 'border border-red-500': forms.errors.phone }" type="text" v-model="forms.phone"
                    :disabled="forms.processing">
                <p v-if="forms.errors.phone" class="text-red-500">
                    {{ forms.errors.phone }}
                </p>
            </div>
            <div class="flex justify-between">
                <Link :href="route('customers.index')" class="border border-primary py-2 text-sm px-4"
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
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    customer: Customer
}>();

const forms = useForm<Pick<Customer, "code" | "name" | "phone">>({
    code: props.customer.code,
    name: props.customer.name,
    phone: props.customer.phone
});
</script>