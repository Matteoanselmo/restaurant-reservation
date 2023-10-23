<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
        <div class="home-button z-3">
            <a href="/" class="btn btn-dark fs-2 rounded-5 shadow w-100" >
                <i class="fa-solid fa-house"></i>
            </a>
        </div>
        <div class="profile-button z-3">
            <button class="btn btn-dark fs-2 rounded-5 shadow w-100" @click="showButton('logout')">
                <i class="fa-regular fa-user"></i>
            </button>
        </div>
        <div class="logout-button z-3 d-none" id="logout">
            <Link :href="route('logout')" method="POST"  class="btn btn-dark fs-2 rounded-5 shadow w-100 text-danger" as="button">
                <i class="fa-solid fa-right-from-bracket"></i>
            </Link>
        </div>
        <div class="full-screen d-flex justify-content-evenly align-items-start flex-wrap" id="dashboard">
            <div style="cursor: pointer;" class="animated animate__fadeIn">
                <Link :href="route('dashboard.date.index')"  class=" my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold" as="button">
                    Date
                </Link>
            </div>
            <div style="cursor: pointer;" class="animated animate__fadeIn">
                <a :href="route('dashboard.artists.index')" class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Artisti
                </a>
            </div>
            <div style="cursor: pointer;" class="animated animate__fadeIn">
                <a :href="route('dashboard.prenotazioni.index')" class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Prenotazioni
                </a>
            </div>
            <div style="cursor: pointer;" class="animated animate__fadeIn">
                <a :href="route('dashboard.resoconto.index')" class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Resoconto
                </a>
            </div>
            <div style="cursor: pointer;" class="animated animate__fadeIn">
                <a :href="route('dashboard.newsletter')" class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Newsletter
                </a>
            </div>
            <div style="cursor: pointer;" class="animated animate__fadeIn">
                <a :href="route('dashboard.rubrica.index')" class="my-card btn-show border border-2 d-flex justify-content-center align-items-center m-3 fw-bold">
                    Rubrica
                </a>
            </div>
        </div>
</template>

<script>
import ApplicationLogo from '../Components/ApplicationLogo.vue';

export default {
    name: 'Dashboard',
    components: {
        ApplicationLogo
    },
    methods: {
        showButton(id){
            const button = document.getElementById(id);
            const view = document.getElementById('dashboard');
            view.classList.toggle('my-blur');
            button.classList.toggle('d-none');
        }
    }
}
</script>

<style >

/* html, body {
    overflow: auto;
} */
.home-button{
    position: absolute;
    left: 50%;
    top:calc((100vh / 3 ) - 2.5rem);
    transform: translateX( -50% );
}
.profile-button{
    position: absolute;
    left: 50%;
    bottom: calc((100vh / 3 ) - 2.5rem);
    transform: translateX(-50%);
}
.logout-button{
    position: absolute;
    left: 60%;
    bottom: 30%;
    transform: translateX(-60%);
    animation: fadeIn .7s; /* Aggiungi la transizione */
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.my-card{
    height: calc((100vh / 3 ) - 3rem);
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
    .home-button,  .profile-button, .logout-button{
        width: 80vw !important;
    }

    .home-button{
        top:calc(50vh / 2 );
    }

    .profile-button{
        bottom: calc(50vh / 2 );
    }

    .logout-button{
        left: 50%;
        transform: translateX(-50%);
        bottom: calc((50vh / 2 ) - 5rem);
    }

    .my-card {
        height: calc((100vh / 4.5 ) - 3rem);
        border-radius: 60px !important;
    }
}
</style>
