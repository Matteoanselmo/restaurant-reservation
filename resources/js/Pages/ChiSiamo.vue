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
            <div class="col-12 about-1 mb-4"></div>
        </div>
        <div class="row mx-2 mb-4">
            <div
                class="col-12 col-md-7 about-description d-flex align-items-center justify-content-center flex-column"
                data-aos="fade-up"
            >
                <h4 class="mb-4">
                    Villa Albertina è unʼode alla bellezza della natura nella
                    sua forma più pura.
                </h4>
                <h4 class="mb-4">
                    Nelle verdi campagne di Argenta, in provincia di Ferrara,
                    lʼarte incontra la tradizione attraverso un vero e proprio
                    viaggio sensoriale.
                </h4>
                <h4>
                    I profumi e i sapori della terra, dove lʼallevamento
                    intensivo non esiste e i piatti sono cucinati rispettando
                    stagionalità e freschezza.
                </h4>
            </div>
            <div class="col-12 col-md-5 about-2">
                <img
                    src="/images/about/about-2.jpg"
                    class="img-thumbnail border-0 p-0"
                    alt=""
                    data-aos="fade-up"
                />
            </div>
        </div>
        <div class="row">
            <div
                class="mb-3"
                v-for="(image, i) in slideImages"
                :key="i"
                :class="i % 2 === 0 ? 'col-5' : 'col-7'"
            >
                <img
                    :src="'/images/about/' + image"
                    class="img-fluid rounded shadow"
                    alt=""
                    data-aos="fade-up"
                />
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

@media screen and (max-width: 767px) {
    .about-1 {
        background-position: top;
        height: 30vh;
        width: 100%;
    }
}
</style>
