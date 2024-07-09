<script setup>
import { reactive, ref, onBeforeUnmount } from "vue";
import { generalStore } from "@/Stores/state";
import ApplicationLogo from "../Components/ApplicationLogo.vue";
const store = generalStore();

const slideImages = reactive([
    "about-slide-1.jpg",
    "about-slide-2.jpg",
    "about-slide-3.jpg",
    "about-slide-4.jpg",
    "about-slide-5.jpg",
    "about-slide-6.jpg",
    "about-slide-7.jpg",
]);

const removeOverflow = () => {
    document.documentElement.style.overflow = "visible";
    document.body.style.overflow = "visible";
};

onBeforeUnmount(() => {
    store.enableOverflowHidden();
});

removeOverflow();
</script>

<template>
    <div class="container-fluid">
        <ApplicationLogo />
        <div class="row">
            <div class="col-12 about-1 position-relative">
                <div
                    class="text-white position-absolute bottom-0 start-50 translate-middle-x w-100 text-center"
                >
                    <p class="mb-1">
                        Villa Albertina è unʼode alla bellezza della natura
                        nella sua forma più pura.
                    </p>
                    <p class="mb-1">
                        Nelle verdi campagne di Argenta, in provincia di
                        Ferrara, lʼarte incontra la tradizione attraverso un
                        vero e proprio viaggio sensoriale.
                    </p>
                    <p class="">
                        I profumi e i sapori della terra, dove lʼallevamento
                        intensivo non esiste e i piatti sono cucinati
                        rispettando stagionalità e freschezza.
                    </p>
                </div>
            </div>
        </div>
        <!-- <div class="row mx-2 mb-4">
            <div
                class="col-12 col-md-7 about-description d-flex align-items-center justify-content-center flex-column"
                data-aos="fade-up"
            ></div>
            <div class="col-12 col-md-5 about-2">
                <img
                    src="/images/about/about-2.jpg"
                    class="img-thumbnail border-0 p-0"
                    alt=""
                    data-aos="fade-up"
                />
            </div>
        </div> -->
        <div class="row">
            <div
                data-aos="fade-up"
                id="carouselExampleIndicators"
                class="carousel slide px-0"
                data-bs-ride="carousel"
            >
                <div class="carousel-indicators">
                    <button
                        type="button"
                        data-bs-target="#carouselExampleIndicators"
                        v-for="(image, index) in slideImages"
                        :data-bs-slide-to="index"
                        :class="{ active: index === 0 }"
                        aria-current="true"
                        aria-label="'Slide ' + (index + 1)"
                        :key="'indicator-' + index"
                    ></button>
                </div>
                <div class="carousel-inner bg-dark">
                    <div
                        v-for="(image, index) in slideImages"
                        :key="index"
                        :class="['carousel-item', { active: index === 0 }]"
                    >
                        <img
                            :src="'/images/about/' + image"
                            class="d-block w-100 img-slide rounded shadow"
                            alt=""
                        />
                    </div>
                </div>
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev"
                >
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next"
                >
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.about-1 {
    background-image: url("../../../public/images/about/about-1.jpg");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
}

.img-slide {
    max-height: 100vh; /* Imposta l'altezza massima delle immagini al 100% dell'altezza della finestra */
    object-fit: contain; /* Ritaglia l'immagine per adattarla alla dimensione del contenitore */
}

@media screen and (max-width: 767px) {
    .about-1 {
        background-position: top;
        height: 30vh;
        width: 100%;
    }
}
</style>
