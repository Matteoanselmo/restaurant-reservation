<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <div class="fixed-top">
        <button @click="toggleSidebar" class="btn-show d-md-none mb-4">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div :class="['sidebar', { 'active': sidebarVisible }]" class="shadow-lg rounded-5 m-4 py-4">
            <div class="d-flex flex-column  align-items-center mb-5" style="backdrop-filter: blur(6px);">
                <button class="btn-show w-50">
                    Date
                </button>
                <button class="btn-show w-50">
                    Artisti
                </button>
                <button class="btn-show w-50">
                    Prenotazioni
                </button>
                <button class="btn-show w-50">
                    Resoconto
                </button>
            </div>
            <div class="d-flex justify-content-evenly align-items-center">
                <button class="btn-show">
                    Profilo
                </button>
                <button class="btn btn-danger">
                    Esci
                </button>
            </div>
        </div>
    </div>
    <div class="full-screen position-relative pt-5" id="dashboard" :class="['content-overlay', { 'active': sidebarVisible }]" @click="closeSidebar">
        <div class="row rounded-5 shadow mx-3">
            <div class="col-12 col-md-4  d-flex align-items-center justify-content-center mb-4 py-3">
                <button class="btn-show">
                    Mare
                </button>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-center justify-content-center mb-4 py-3">
                <button class="btn-show">
                    Special
                </button>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-center justify-content-center mb-4 py-3">
                <button class="btn-show">
                    Terra
                </button>
            </div>
        </div>
    </div>

    <!-- <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout> -->
</template>

<script>
import ApplicationLogo from '../Components/ApplicationLogo.vue'
export default {
    name: 'Dashboard',
    components: {
        ApplicationLogo
    },
    data() {
        return {
            sidebarVisible: false,
        };
    },
    methods: {
        toggleSidebar() {
            this.sidebarVisible = !this.sidebarVisible;
        },
        closeSidebar() {
            this.sidebarVisible = false;
        },
    },
}
</script>

<style>
    /* Stili per la sidebar */
.sidebar {
  /* Stili della sidebar nascosta */
    transform: translateX(-200%);
    transition: transform 0.3s ease-in-out;
}

/* Stili per la sidebar visibile */
.sidebar.active {
    transform: translateX(0);
}
.content-overlay.active{
    filter: blur(6px);
}
</style>
