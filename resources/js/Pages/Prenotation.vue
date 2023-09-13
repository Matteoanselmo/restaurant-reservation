<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1>
                    Prenotazione per {{new Date(data[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </h1>
            </div>
            <div class="col-12 col-md-3 border-end border-2">
                <h2 class="text-uppercase text-center">riepilogo</h2>
            </div>
            <div class="col-12 col-md-9 justify-content-center d-flex flex-column mb-5">
                <div v-for="(chair, i) in prenotationsFiltrate" :key="i" class="border-bottom border-2 rounded-3 px-3 mb-4 ">
                    <h3>Posto n° {{ chair.n_posto }}</h3>
                    <h3>Nome: {{ chair.nome }}</h3>
                    <h3>Cognome: {{ chair.cognome }}</h3>
                    <h3>Email: {{ chair.email }}</h3>
                    <h3>Numero di telefono: {{ chair.n_telefono }}</h3>
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn-show text-uppercase border border-2">prenota</button>
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
        // Filtra gli oggetti non vuoti in base ai campi nome, cognome, email e n_telefono
        const prenotationsFiltrate = store.prenotations.filter((prenotazione) => {
            return (
                prenotazione.nome !== "" ||
                prenotazione.cognome !== "" ||
                prenotazione.email !== "" ||
                prenotazione.n_telefono !== ""
            );
        });
        return {
            data,
            prenotationsFiltrate
        }
    }
}
</script>

<style>

</style>
