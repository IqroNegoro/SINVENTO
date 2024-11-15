<template>
    <div class="p-4 flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-3xl">User</h1>
        </div>
        <form @submit.prevent="forms.put(route('user.update', props.user.id), {
            onSuccess: () => forms.reset('username', 'password')
        })" class="bg-white p-4 rounded-sm flex flex-col gap-4" method="POST">
            <div>
                <p>Name</p>
                <input type="text" v-model="forms.name">
            </div>
            <div>
                <p>Username</p>
                <input type="text" v-model="forms.username">
            </div>
            <div>
                <p>Password</p>
                <input type="password" v-model="forms.password">
            </div>
            <button class="bg-primary py-2 text-sm px-4 self-end" type="submit">
                Update
            </button>
        </form>
    </div>
</template>
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    user: {
        id: number,
        username: string,
        password: string,
        name: string
    }
}>();

const forms = useForm<{
    username: string,
    password: string,
    name: string
}>({
    name: props.user.name,
    username: "",
    password: "",
})
</script>