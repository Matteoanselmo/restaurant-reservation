<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4 d-flex aling-items-center justify-content-between py-2 position-relative">
                <a :href="route('dashboard')" class="btn-show border border-2 position-absolute top-0 start-0 m-2"><i class="fa-solid fa-chevron-left"></i></a>
                <h1 class="text-capitalize text-center m-0 m-auto">
                    prenotazioni
                </h1>
                <a :href="route('dashboard.prenotazioni.scadute')" class="btn-show border border-2">Scadute</a>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-4 normal-font rounded-5 p-3 border border-2 shadow" v-for="(prenotazione, index) in prenotazioni" :key="index">
                <div class="text-center mb-3">
                    <h3 class="text-capitalize">
                        {{new Date(prenotazione.data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                    </h3>
                    <h6>{{ prenotazione.titolo }} - <span class="text-secondary">{{ prenotazione.pranzo_cena }}</span></h6>
                </div>
                <div class="d-flex justify-content-evenly flex-wrap">
                    <h6 v-for="(posto, x) in prenotazione.bookings" :key="x" class="text-secondary">
                        {{ posto.posto }}
                    </h6>
                </div>
                <!-- {{ prenotazione.bookings }} -->
                <a :href="route('dashboard.prenotazioni.prenotati', {id:prenotazione.id})"  class="btn-show border border-2">Gestisci Spettatori</a>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
export default {
    name:'prenotazioniIndex',
    components: {
        Link
    },
    setup(){
        const page = usePage();
        const prenotazioni = computed(() => page.props.prenotazioni);

        onMounted(() => {
            console.log(prenotazioni.value);
        })

        return {
            prenotazioni
        }
    }
}
</script>

<style>

</style>
