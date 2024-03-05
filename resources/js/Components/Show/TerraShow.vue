<template>
    <div class="container-fluid position-relative">
        <div
            class="row overflow-y-scroll"
            style="max-height: calc(100vh - 70px)"
            @scroll="checkScrollPosition"
        >
            <div
                class="col-12 d-flex align-items-center justify-content-between mb-2"
            >
                <button
                    class="btn-show border border-2"
                    @click="scrollToSection('chose-show')"
                >
                    <i class="fa-solid fa-chevron-left fs-3"></i>
                </button>
                <h2 class="text-capitalize">
                    {{ $t("artists.ground") }}
                </h2>
                <div></div>
            </div>
            <div class="col-12">
                <h3>Storia degli artisti di terra</h3>
            </div>
            <!-- <div class="col-6 col-md-4 col-lg-3 animate__animated animate__pulse" v-for="(artista, i) in specialArtists" :key="i" >
                <div class="rounded-5 border border-2 p-2 mb-4 position-relative guest-artist-card py-5 w-100 h-100">
                    <div class="position-absolute top-0 start-0 h-100 w-100 my-blur ">
                        <img :src="'/' + artista.img_path" alt="" class="h-100 w-100 artist-img rounded-5">
                    </div>
                    <div class="position-absolute top-50 start-50 translate-middle z-2 d-flex flex-column justify-content-center align-items-center h-100 w-100">
                        <h2 class="text-start text-capitalize">
                            {{ artista.titolo }}
                        </h2>
                        <h5 class="text-uppercase normal-font">
                            {{ artista.show_type.nome }}
                        </h5>
                        <div class="d-flex flex-column justify-content-evenly align-items-center h-50">
                            <p class="artist-description normal-font">
                                {{ artista.descrizione }}
                            </p>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-12">
                <button
                    class="position-absolute start-50 translate-middle-x btn-show my-btn-bottom border border-2"
                    @click="scrollToSection('terra-date')"
                >
                    Date
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
export default {
    name: "TerraShow",
    setup() {
        function scrollToSection(sectionId) {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: "smooth" });
            }
        }
        const specialArtists = ref([]);

        onMounted(() => {
            axios
                .post(`/api/filtered-artist/${3}`)
                .then((res) => {
                    specialArtists.value = res.data.artistiFiltrati;
                })
                .catch((err) => {
                    console.error(err);
                });
        });

        return {
            scrollToSection,
            specialArtists,
        };
    },
    mounted() {
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

            if (deltaX < swipeThreshold) {
                // Calcola la direzione dello swipe
                const sectionId = "chose-show"; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
            }

            if (deltaY > swipeThreshold) {
                // Calcola la direzione dello swipe
                const sectionId = "terra-date"; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
            }
        });
    },
};
</script>

<style scoped></style>
