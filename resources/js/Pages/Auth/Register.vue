<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form
            @submit.prevent="submit"
            class="max-w-lg mx-auto bg-white p-8 rounded-2xl border-2 border-dashed border-teal-500"
        >
            <div class="text-center mb-6">
                <h2 class="text-4xl font-bold text-purple-700 mb-2">
                    Register Now!✨
                </h2>
                <p class="text-lg text-gray-500">
                    Let's get you set up in just a few steps
                </p>
            </div>

            <div>
                <InputLabel
                    for="name"
                    value="Full Name"
                    class="text-lg font-semibold text-purple-600"
                />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full px-4 py-2 rounded-lg bg-lavender-100 border-2 border-lavender-300 focus:ring-2 focus:ring-lavender-500 focus:outline-none transition-all"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-6">
                <InputLabel
                    for="email"
                    value="Email Address"
                    class="text-lg font-semibold text-purple-600"
                />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full px-4 py-2 rounded-lg bg-lavender-100 border-2 border-lavender-300 focus:ring-2 focus:ring-lavender-500 focus:outline-none transition-all"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-6">
                <InputLabel
                    for="password"
                    value="Password"
                    class="text-lg font-semibold text-purple-600"
                />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full px-4 py-2 rounded-lg bg-lavender-100 border-2 border-lavender-300 focus:ring-2 focus:ring-lavender-500 focus:outline-none transition-all"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-6">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                    class="text-lg font-semibold text-purple-600"
                />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full px-4 py-2 rounded-lg bg-lavender-100 border-2 border-lavender-300 focus:ring-2 focus:ring-lavender-500 focus:outline-none transition-all"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-6 flex items-center justify-between">
                <span class="text-sm text-gray-600"
                    >Already have an account?</span
                >
                <Link
                    :href="route('login')"
                    class="text-sm font-semibold text-teal-500 hover:text-teal-700 underline transition-all"
                >
                    Log in here
                </Link>
            </div>

            <div class="mt-8">
                <PrimaryButton
                    class="w-full flex justify-center py-3 text-lg font-semibold text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-xl hover:bg-gradient-to-l transition-all transform hover:scale-105"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    Register✨
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
/* Add unified color scheme for inputs */
.bg-lavender-100 {
    background-color: #e9d5ff;
}

.border-lavender-300 {
    border-color: #d8b3f5;
}

.focus\:ring-lavender-500 {
    --tw-ring-color: #9b4de6;
}

/* Smooth transitions */
input,
button {
    transition: all 0.3s ease;
}

input:focus,
button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Gradient background for the button */
.bg-gradient-to-r {
    background-image: linear-gradient(to right, #ec4899, #7c3aed);
}

.bg-gradient-to-l {
    background-image: linear-gradient(to left, #ec4899, #7c3aed);
}

/* Disabled button style */
button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
}
</style>
