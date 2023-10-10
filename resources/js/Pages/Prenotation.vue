<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="text-capitalize">
                    <span >{{ data[0].pranzo_cena }}</span> per {{new Date(data[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </h1>
            </div>
            <div class="col-12 col-md-3 border-end border-2">
                <h2 class="text-uppercase text-center">riepilogo</h2>
            </div>
            <div class="col-12 col-md-9 justify-content-center d-flex flex-column mb-5">
                <div v-for="(chair, i) in store.prenotationsWithRequiredFields" :key="i" class="border-bottom border-2 rounded-3 px-3 mb-4 ">
                    <h3>Posto n° {{ chair.n_posto }}</h3>
                    <h3>Nome: {{ chair.nome }}</h3>
                    <h3>Cognome: {{ chair.cognome }}</h3>
                    <h3>Email: {{ chair.email }}</h3>
                    <h3>Numero di telefono: {{ chair.n_telefono }}</h3>
                </div>
            </div>
            <div class="col-12 text-center">
                <a  @click="store.setData(data[0].data, data[0].pranzo_cena)" :href="route('payment')" class="btn-show text-uppercase border border-2">Vai al Pagamento</a>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import {generalStore} from '@/Stores/state';
export default {
    name: 'Prenotation',
    setup(){
        const page = usePage();
        const data = computed(() => page.props.data)
        const store = generalStore();
        return {
            data,
            store
        }
    }
}
</script>

<style>

</style>
