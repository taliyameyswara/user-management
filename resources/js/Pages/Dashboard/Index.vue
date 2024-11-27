<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3"; // Import useForm hook
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    users: Array, // List of users passed from the controller
});

const showModal = ref(false);
const isEditMode = ref(false);

// Initialize form using useForm hook
const form = useForm({
    id: null,
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

// Open Create Modal
const openCreateModal = () => {
    isEditMode.value = false;
    form.id = null;
    form.name = "";
    form.email = "";
    form.password = "";
    form.password_confirmation = "";
    showModal.value = true;
};

// Open Edit Modal
const openEditModal = (user) => {
    isEditMode.value = true;
    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.password = "";
    form.password_confirmation = "";
    showModal.value = true;
};

// Close the modal
const closeModal = () => {
    showModal.value = false;
};

// Submit the form (Create or Update)
const saveUser = () => {
    if (isEditMode.value) {
        // Update existing user using form.put()
        form.put(route("users.update", form.id), {
            onSuccess: () => {
                closeModal();
            },
        });
    } else {
        // Create new user using form.post()
        form.post(route("users.store"), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Delete user
const deleteUser = (id) => {
    if (confirm("Are you sure you want to delete this user?")) {
        form.delete(route("users.destroy", id), {
            onSuccess: () => {},
        });
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Users List</h3>
                        <button
                            @click="openCreateModal"
                            class="mb-4 px-4 py-2 bg-blue-500 text-white rounded-md"
                        >
                            Create New User
                        </button>
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500"
                                    >
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="user in users"
                                    :key="user.id"
                                    class="border-b"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        {{ user.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                    >
                                        {{ user.email }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                    >
                                        <button
                                            @click="openEditModal(user)"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="deleteUser(user.id)"
                                            class="text-red-600 hover:text-red-800 ml-4"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Create/Edit User -->
        <div
            v-if="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                <h3 class="text-xl font-semibold mb-4">
                    {{ isEditMode ? "Edit User" : "Create User" }}
                </h3>
                <form @submit.prevent="saveUser">
                    <div class="mb-4">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            id="name"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            id="email"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        />
                    </div>
                    <div class="mb-4" v-if="!isEditMode">
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                            >Password</label
                        >
                        <input
                            v-model="form.password"
                            type="password"
                            id="password"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        />
                    </div>
                    <div class="mb-4" v-if="!isEditMode">
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-gray-700"
                            >Confirm Password</label
                        >
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            id="password_confirmation"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        />
                    </div>
                    <div class="flex justify-end">
                        <button
                            @click="closeModal"
                            type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md"
                        >
                            {{ isEditMode ? "Update" : "Create" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Styling for modal */
.fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
