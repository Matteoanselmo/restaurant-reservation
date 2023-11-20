<template>
    <div class="container-fluid d-flex flex-column px-3 justify-content-start mt-3 position-relative" id="prenotation-table">
        <div class="d-flex flex-column align-items-center position-absolute top-0 start-0 m-1">
            <a class="btn-show" href="/">
                <i class="fa-solid fa-chevron-left  fs-3" ></i>
            </a>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-evenly">

                <div class="col-12 mb-5">
                    <h1 class="text-center text-capitalize">
                        {{new Date(newDate[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                    </h1>
                </div>
                <div class="col-12 col-md-5 d-flex flex-column align-items-center justify-content-center border-bottom border-2 mb-5"  v-for="(data, i) in newDate" :key="i">
                    <div id="myCarousel">
                        <div class="carousel-inner mb-4">
                        <Carousel >
                            <Slide  v-for="(image, index) in data.images" :key="index">
                                <img :src="image.path" class="carousel__item" alt="...">
                            </Slide>

                            <template #addons>
                            <Navigation />
                            <Pagination />
                            </template>
                        </Carousel>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <h1 class="text-uppercase text-center">
                        {{ data.titolo }}
                    </h1>
                    <h1 class="text-uppercase">{{ data.pranzo_cena }} {{ newDate[0].show_type.nome }}</h1>
                    <h3 class="mb-5">
                        {{ data.descrizione }}
                    </h3>
                    <h3 class="mb-4">&euro;{{ data.prezzo }} p.p.</h3>
                    <a :href="route('scelta.posti', {id: data.id})" class="btn-show border border-2 mb-4 text-uppercase">seleziona posti</a>
                    <h3>diponibili: {{ store.prenotations.length - data.bookings.length }}</h3>
                </div>
            </div>
        </div>
        <div></div>
    </div>

</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount } from 'vue';
import {generalStore} from '@/Stores/state';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
export default {
    name: 'GuestShowMare',
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    setup(){
        const page = usePage()
        const date = computed(() => page.props.data)
        const newDate = date;
        const alert = ref([]);
        const store = generalStore();
        console.log(newDate.value)
        onMounted(() => {
            store.disableOverflowHidden();
        })

        onBeforeUnmount(() => {
            store.enableOverflowHidden();
        });

        return {
            date,
            newDate,
            alert,
            store,
        }
    }
}
</script>

<style>
    #prenotation-table{
        overflow: auto;
    }
    .carousel__item {
        min-height: 200px;
        width: 100%;
        background-color: var(--vc-clr-primary);
        color: var(--vc-clr-white);
        font-size: 20px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .carousel__slide {
        padding: 10px;
        }

        .carousel__prev,
        .carousel__next {
            box-sizing: content-box;
            border: 5px solid white;
            border-radius: 50%;
            color: white;
            backdrop-filter: blur(6px) brightness(60%);
            padding: 10px;
        }
</style>
