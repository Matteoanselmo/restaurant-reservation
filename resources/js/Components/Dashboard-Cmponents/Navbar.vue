<template>
    <div class="fixed-top">
        <button @click="toggleSidebar" class="btn-show mb-4">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <transition  name="sidebar-fade">
            <div v-show="sidebarVisible" class="shadow-lg rounded-5 bg-white m-4 py-4">
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
        </transition>
    </div>
</template>

<script>
export default {
    name: 'NavBar',
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
.sidebar-fade-enter-active,
.sidebar-fade-leave-active {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.sidebar-fade-enter, .sidebar-fade-leave-to {
    opacity: 0;
    transform: translateX(-100%); /* Parte fuori dalla view */
}
.sidebar-fade-leave-active {
    transform: translateX(100%); /* Esce verso destra */
}
.content-overlay.active{
    filter: brightness(0.7) blur(6px);
}
</style>
