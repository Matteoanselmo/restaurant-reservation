<template>
    <div class="container-fluid position-relative">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between mb-4">
                <a class="btn-show border border-2" :href="route('dashboard')">
                    <i class="fa-solid fa-chevron-left  fs-3" ></i>
                </a>
                <h1 class="text-center text-capitalize">
                    artisti
                </h1>
                <div></div>
            </div>
            <div class="col-12" v-if="message">
                {{ message }}
            </div>
            <div class="col-6 col-md-4 " v-for="(artista, i) in artisti" :key="i" >
                <div class="rounded-5 border border-2 p-2 mb-4 position-relative artist-card py-5">
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
            </div>
        </div>
        <a :href="route('dashboard.artists.create')" class="btn-show border border-2 position-fixed end-0 bottom-0 m-3"><i class="fa-solid fa-plus"></i></a>
    </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
export default {
    name: 'ArtistiIndex',
    setup(){
        const page = usePage();
        const message = computed(()=> page.props.message)
        const artisti = computed(() => page.props.artisti);

        onMounted(() => {
            console.log(artisti.value)
        })

        return {
            artisti,
            message
        }
    }
}
</script>

<style scoped>

</style>
