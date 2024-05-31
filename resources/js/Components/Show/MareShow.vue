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
                <div></div>
                <h2 class="me-3 text-capitalize">
                    {{ $t("artists.sea") }}
                </h2>
                <button
                    class="btn-show border border-2"
                    @click="scrollToSection('chose-show')"
                >
                    <i class="fa-solid fa-chevron-right fs-3"></i>
                </button>
            </div>
            <div class="col-12">
                <h3>Storia degli artisti di mare</h3>
            </div>
            <!-- <div class="col-6 col-md-4 col-lg-3 animate__animated animate__pulse" v-for="(artista, i) in mareArtists" :key="i" >
                <div class="rounded-5 border border-2 p-2 mb-4 position-relative  guest-artist-card py-5">
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
                    @click="scrollToSection('mare-date')"
                >
                    Date
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
    name: "MareShow",
    setup() {
        const mareArtists = ref([]);

        const scrollToSection = (sectionId) => {
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: "smooth" });
            }
        };

        const checkScrollPosition = () => {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: "smooth" });
            }
        };

        onMounted(() => {
            axios
                .post(`/api/filtered-artist/${1}`)
                .then((res) => {
                    mareArtists.value = res.data.artistiFiltrati;
                })
                .catch((err) => {
                    console.error(err);
                });

            let initialTouchX = 0;
            let initialTouchY = 0;

            const handleTouchStart = (e) => {
                initialTouchX = e.touches[0].clientX;
                initialTouchY = e.touches[0].clientY;
            };

            const handleTouchEnd = (e) => {
                const deltaX = initialTouchX - e.changedTouches[0].clientX;
                const deltaY = initialTouchY - e.changedTouches[0].clientY;
                const swipeThresholdY = 200;
                const swipeThresholdX = 80;

                if (deltaX > swipeThresholdX) {
                    scrollToSection("chose-show");
                }

                if (deltaY > swipeThresholdY) {
                    scrollToSection("mare-date");
                }
            };

            const element = document.querySelector(".container-fluid");
            if (element) {
                element.addEventListener("touchstart", handleTouchStart);
                element.addEventListener("touchend", handleTouchEnd);
            }
        });

        return {
            mareArtists,
            scrollToSection,
            checkScrollPosition,
        };
    },
};
</script>

<style scoped></style>
