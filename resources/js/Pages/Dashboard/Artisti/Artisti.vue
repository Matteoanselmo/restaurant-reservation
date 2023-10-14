<template>
    <div class="container-fluid position-relative">
        <div class="row">
            <div class="col-12  mb-4">
                <h1 class="text-center text-capitalize">
                    artisti
                </h1>
            </div>
            <div class="col-12" v-if="message">
                {{ message }}
            </div>
            <div class="col-6 col-md-4" v-for="(artista, i) in artisti" :key="i">
                <div class="rounded-5 border border-2 p-2 mb-4">
                    <h2 class="text-center text-capitalize">
                        {{ artista.titolo }}
                    </h2>
                    <p>
                        {{ artista.descrizione }}
                    </p>
                </div>
            </div>
        </div>
        <a :href="route('dashboard.artists.create')" class="btn-show border border-2"><i class="fa-solid fa-plus"></i></a>
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

        })

        return {
            artisti,
            message
        }
    }
}
</script>

<style>

</style>
