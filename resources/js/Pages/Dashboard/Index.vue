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
        form.put(route("users.update", form.id), {
            onSuccess: () => {
                closeModal();
            },
        });
    } else {
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
            <h2 class="text-2xl font-bold leading-tight text-white">
                User Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white rounded-2xl border-2 border-dashed border-pink-500"
                >
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between">
                            <h3
                                class="text-xl font-semibold mb-6 text-purple-600"
                            >
                                Users List
                            </h3>
                            <button
                                @click="openCreateModal"
                                class="mb-4 px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-700 text-white rounded-xl text-lg shadow-lg transform hover:scale-105 transition-transform"
                            >
                                Create New User
                            </button>
                        </div>
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr
                                    class="bg-gradient-to-b from-pink-100 to-purple-100"
                                >
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-600"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-600"
                                    >
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-600"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="user in users"
                                    :key="user.id"
                                    class="border-b border-gray-200 hover:bg-purple-50"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                                    >
                                        {{ user.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                                    >
                                        {{ user.email }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                    >
                                        <button
                                            @click="openEditModal(user)"
                                            class="text-blue-600 hover:text-blue-800 transition-all duration-300"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="deleteUser(user.id)"
                                            class="text-red-600 hover:text-red-800 ml-4 transition-all duration-300"
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
            <div class="bg-white rounded-xl shadow-xl w-1/3 p-6">
                <h3 class="text-xl font-semibold mb-6 text-purple-600">
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
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-400"
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
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-400"
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
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-400"
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
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-400"
                        />
                    </div>
                    <div class="flex justify-end">
                        <button
                            @click="closeModal"
                            type="button"
                            class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg mr-4 transition-all"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-700 text-white rounded-lg shadow-lg transform hover:scale-105 transition-all"
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
/* Modal and Button Styling */
.fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

button:focus {
    outline: none;
}

/* Apply gradient to buttons and inputs */
.bg-gradient-to-r {
    background-image: linear-gradient(to right, #ec4899, #7c3aed);
}

.bg-gradient-to-l {
    background-image: linear-gradient(to left, #ec4899, #7c3aed);
}

/* Hover effects */
input,
button {
    transition: all 0.3s ease;
}

input:focus,
button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
}
</style>
