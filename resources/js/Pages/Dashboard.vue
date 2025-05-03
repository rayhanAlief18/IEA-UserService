<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    orders: Array
});

const orders = ref([]);
// Ambil data dari API saat komponen mounted
onMounted(async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/getUser'); // Ganti jika endpoint-mu berbeda
        orders.value = response.data.data;
    } catch (error) {
        console.error("Gagal mengambil data order:", error);
    }
});

function lihatDetailUser($id_user) {
    router.get(`/user/${$id_user}/order`);
}

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>

                <div class="container mx-auto px-4 sm:px-8">
                    <div class="py-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Daftar user</h2>
                        </div>
                        <div class="overflow-x-auto rounded-xl shadow-lg">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">No</th>
                                        <th class="py-3 px-6 text-left">Nma Pemesana</th>
                                        <th class="py-3 px-6 text-left">Email</th>
                                        <th class="py-3 px-6 text-left">Role</th>
                                        <th class="py-3 px-6 text-left">Status</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="text-gray-700 text-sm font-light">
                                    <tr v-for="(order, index) in orders" :key="order.id"
                                        class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ index + 1 }}</td>
                                        <td class="py-3 px-6 text-left">{{ order.name }}</td>
                                        <td class="py-3 px-6 text-left ">{{ order.email }}</td>
                                        <td class="py-3 px-6 text-left"><span
                                                :class="{ ' text-xs px-2 py-1 rounded-full bg-green-100 text-green-800': order.role === 'admin' }">{{
                                                order.role }}</span></td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="text-xs px-2 py-1 rounded-full" :class="{
                                                'bg-green-100 text-green-800': order.status === 'aktif',
                                                'bg-red-100 text-red-800': order.status === 'non-aktif'
                                            }">
                                                {{ order.status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <button @click="lihatDetailUser(order.id)"
                                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs py-1 px-3 rounded-lg">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="orders.length === 0">
                                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data user</td>
                                    </tr>
                                    <!-- Tambahkan baris lain sesuai data -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </AuthenticatedLayout>
</template>
