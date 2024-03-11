<script setup>
import { Head } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import ApplicationLogo from "../Components/ApplicationLogo.vue";
import Lode from "../Components/Lode.vue";
import NotARestaurant from "../Components/NotARestaurant.vue";
import ChoseShow from "../Components/Show/ChoseShow.vue";
import MareShow from "../Components/Show/MareShow.vue";
import TerraShow from "../Components/Show/TerraShow.vue";
import SpecialShow from "../Components/Show/SpecialShow.vue";
import DateMare from "../Components/Date/DateMare.vue";
import DateSpacial from "../Components/Date/DateSpacial.vue";
import DateTerra from "../Components/Date/DateTerra.vue";
import { generalStore } from "@/Stores/state";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const store = generalStore();
const restaurantRef = ref(null);
const lodeRef = ref(null);
const showRef = ref(null);

onMounted(() => {
    store.setVisited();
    if (getCookie("isVisited")) {
        showRefView();
    } else {
        setCookie("isVisited", true, 30);
        setTimeout(() => {
            scrollComponent(restaurantRef);
        }, 1500);
    }
});

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return false;
}

async function scrollComponent(ref) {
    if (ref && ref.value) {
        ref.value.$el.scrollIntoView({
            behavior: "smooth",
            block: "start",
        });
        await new Promise((resolve) => setTimeout(resolve, 1000));
        const nextRef = getNextRef(ref);

        if (nextRef) {
            scrollComponent(nextRef);
        }
    }
}

function showRefView() {
    if (showRef && showRef.value) {
        showRef.value.$el.scrollIntoView({
            block: "start",
        });
    }
}

function getNextRef(currentRef) {
    if (currentRef === restaurantRef) {
        return lodeRef;
    } else if (currentRef === lodeRef) {
        return showRef;
    } else {
        return null; // Termina lo scorrimento qui
    }
}
</script>

<template>
    <Head title="Welcome" />
    <div id="home">
        <button-info></button-info>
        <div>
            <ApplicationLogo
                class="full-screen d-flex justify-content-center align-items-center overflow-hidden animate__animated animate__slideInUp"
                ref="appLogoRef"
            />
            <NotARestaurant
                class="full-screen d-flex justify-content-center align-items-center overflow-hidden animate__animated animate__zoomIn"
                ref="restaurantRef"
            />
            <lode
                class="full-screen d-flex flex-column px-5 justify-content-center align-items-center overflow-hidden"
                ref="lodeRef"
            />
        </div>
        <div class="d-flex">
            <div>
                <MareShow class="full-screen" id="mare-show" />
                <DateMare
                    class="full-screen d-flex flex-column align-items-center justify-content-start my-4 animated animate__fadeInLeft"
                    id="mare-date"
                />
            </div>
            <div>
                <ChoseShow
                    class="full-screen d-flex justify-content-center align-items-center"
                    id="chose-show"
                    ref="showRef"
                />
                <!-- <div>
                    <SpecialShow class="full-screen" id="special-show" />
                    <DateSpacial
                        class="full-screen d-flex flex-column justify-content-start align-items-center"
                        id="special-date"
                    />
                </div> -->
            </div>
            <div>
                <TerraShow class="full-screen" id="terra-show" />
                <DateTerra
                    class="full-screen d-flex flex-column justify-content-start align-items-center"
                    id="terra-date"
                />
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
#chose-show {
    background-image: url("../../../public/images/logo/chose-min.JPG");
    background-position: top;
    background-size: cover;
    background-repeat: no-repeat;
}

@media screen and (max-width: 767px) {
    #chose-show {
        background-position: 75%;
    }
}
</style>
