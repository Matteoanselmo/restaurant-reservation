<template>
    <div class="d-flex flex-column justify-content-evenly py-3">
        <div class="px-3 text-center">
            <h1 class="mb-3 fw-bold text-white">
                {{ $t("chose_menu.title") }}
            </h1>
            <h5 class="normal-font" style="color: #41464b">
                {{ $t("chose_menu.sub_title") }}
            </h5>
        </div>
        <div class="d-flex w-100 align-items center justify-content-evenly">
            <button
                class="btn-show border border-2 animated animate__fadeIn"
                v-for="(show, index) in allShow"
                :key="index"
                @click="scrollToSection(show.routeId)"
            >
                <span v-if="show.tipo === 'mare'">{{ $t("menu.sea") }}</span>
                <span v-if="show.tipo === 'terra'">{{
                    $t("menu.ground")
                }}</span>
            </button>
        </div>
        <div class="d-flex w-100 align-items center justify-content-evenly">
            <button
                class="btn-show border border-2 animated animate__fadeIn"
                @click="scrollToSection('special-show')"
            >
                <span>special</span>
            </button>
            <!-- <Link
                :href="route('create.menu')"
                class="btn-show border border-2 animated animate__fadeIn"
            >
                {{ $t("menu.create_menu") }}
            </Link> -->
        </div>
        <div>
            <a :href="route('create.menu')" class="animated animate__fadeIn">
                {{ $t("menu.have_buisness") }}
            </a>
        </div>
    </div>
</template>

<script>
import { generalStore } from "@/Stores/state";
import { Link } from "@inertiajs/vue3";
export default {
    name: "ChoseShow",
    components: {
        Link,
    },
    data() {
        return {
            store: generalStore(),
            allShow: [
                {
                    tipo: "mare",
                    routeId: "mare-show",
                },
                // {
                //     tipo: 'special',
                //     routeId: 'special-show'
                // },
                {
                    tipo: "terra",
                    routeId: "terra-show",
                },
            ],
        };
    },
    methods: {
        scrollToSection(sectionId) {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: "smooth" });
            }
        },
        handleIntersection(entries) {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    this.store.setVisited();
                }
            });
        },
    },
    mounted() {
        // verifico di essere all'interno DELLA VIEW
        const options = {
            root: null, // viewport
            rootMargin: "0px",
            threshold: 0.5, // il componente è considerato visibile quando è almeno per il 50% nel viewport
        };

        const observer = new IntersectionObserver(
            this.handleIntersection,
            options
        );
        observer.observe(this.$el);

        // METTO IN ASCOLTO UN LISTNER PER I TOUCH SWIPE
        let initialTouchX = 0;
        let initialTouchY = 0;

        // Aggiungi un listener per il gesto di swipe
        this.$el.addEventListener("touchstart", (e) => {
            initialTouchX = e.touches[0].clientX;
            initialTouchY = e.touches[0].clientY;
        });

        this.$el.addEventListener("touchend", (e) => {
            const deltaX = initialTouchX - e.changedTouches[0].clientX;
            const deltaY = initialTouchY - e.changedTouches[0].clientY;
            // Definisci una soglia per determinare quando considerare il gesto come uno swipe
            const swipeThreshold = 50;

            if (deltaX < -swipeThreshold) {
                // Calcola la direzione dello swipe nell'asse X
                const sectionId = "mare-show"; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
                console.log("X: " + deltaX);
            } else if (deltaX > swipeThreshold) {
                const sectionId = "terra-show"; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
                console.log("X: " + deltaX);
            }
        });
    },
    created() {},
};
</script>

<style lang="scss" scoped>
// #primal-chose-show{
//     backdrop-filter: blur(6px);
// }
</style>
