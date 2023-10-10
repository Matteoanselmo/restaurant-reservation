<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4 d-flex aling-items-center justify-content-between py-2">
                <a :href="route('dashboard.prenotazioni.index')" class="btn-show border border-2"><i class="fa-solid fa-chevron-left"></i></a>
                <h1 class="text-capitalize text-center m-auto">
                    prenotazioni scadute
                </h1>
                <div></div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-4 normal-font" v-for="(prenotazione, index) in prenotazioni" :key="index">
                <div class="btn-show border border-2">
                    <h3 class="text-capitalize">
                        {{new Date(prenotazione.data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                    </h3>
                    <h6>{{ prenotazione.pranzo_cena }}</h6>
                    <div class="d-flex justify-content-evenly flex-wrap">
                        <h6 v-for="(posto, x) in prenotazione.bookings" :key="x" class="text-secondary">
                            {{ posto.posto }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
export default {
    name:'prenotazioniVechie',
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
