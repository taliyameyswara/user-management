<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form
            @submit.prevent="submit"
            class="max-w-lg mx-auto bg-white p-8 rounded-2xl mt-12 border-2 border-dashed border-pink-500"
        >
            <div class="text-center mb-6">
                <h2 class="text-3xl font-semibold text-purple-700">
                    Welcome Back! 🌈
                </h2>
                <p class="text-sm text-gray-500">
                    Let's get you logged in to your account
                </p>
            </div>

            <div>
                <InputLabel
                    for="email"
                    value="Email"
                    class="text-lg font-medium text-indigo-600"
                />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full px-4 py-2 rounded-lg bg-indigo-100 border-2 border-indigo-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-6">
                <InputLabel
                    for="password"
                    value="Password"
                    class="text-lg font-medium text-indigo-600"
                />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full px-4 py-2 rounded-lg bg-indigo-100 border-2 border-indigo-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm text-gray-600"
                    >Don't have an account?</span
                >
                <Link
                    :href="route('register')"
                    class="text-sm font-semibold text-pink-500 hover:text-pink-700 underline transition-all"
                >
                    Register
                </Link>
            </div>

            <div class="mt-8 flex justify-center">
                <PrimaryButton
                    class="w-full py-3 text-lg font-semibold text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-xl shadow-xl hover:bg-gradient-to-l transition-all transform hover:scale-105 justify-center"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    Log in 🚀
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
input,
button {
    transition: all 0.3s ease;
}

input:focus,
button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.bg-indigo-100 {
    background-color: #e0e7ff;
}

.bg-gradient-to-r {
    background-image: linear-gradient(to right, #ec4899, #7c3aed);
}

.bg-gradient-to-l {
    background-image: linear-gradient(to left, #ec4899, #7c3aed);
}

button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
}
</style>
