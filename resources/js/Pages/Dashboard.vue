<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
        <div class="full-screen position-relative d-flex justify-content-center align-items-center flex-wrap">
            <div class="position-absolute top-50 start-50 translate-middle z-3">
                <button class="btn btn-dark fs-2 rounded-5 shadow " fw-bold>
                    <i class="fa-solid fa-house"></i>
                </button>
            </div>
            <div>
                <a class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Date
                </a>
            </div>
            <div>
                <a class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Artisti
                </a>
            </div>
            <div>
                <a class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Prenotazioni
                </a>
            </div>
            <div>
                <a class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Resoconto
                </a>
            </div>
        </div>
</template>

<script>
import ApplicationLogo from '../Components/ApplicationLogo.vue'
export default {
    name: 'Dashboard',
    components: {
        ApplicationLogo
    }
}
</script>

<style >

html, body {
    overflow: auto;
}

.my-card{
    height: calc(50vh - 3rem);
    width: calc(50vw - 3rem);
}
/* @media (max-width: 1199.98px) {
    .my-card {
        height: calc(25vh - 3rem);
    }
}

@media (max-width: 991.98px) {
    .my-card {
        height: calc(25vh - 3rem);
    }
}

@media (max-width: 767.98px) {
    .my-card {
        height: calc(25vh - 3rem);
    }
} */

@media (max-width: 575.98px) {
    .my-card {
        height: calc(25vh - 3rem);
        border-radius: 25px !important;
    }
}
</style>
