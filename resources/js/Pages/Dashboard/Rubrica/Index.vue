<template>
    <div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12 position-relative">
            <a :href="route('dashboard')" class="btn-show border border-2 position-absolute top-0 start-0 m-2 z-2"><i class="fa-solid fa-chevron-left"></i></a>
            <h1 class="text-capitalize text-center">Rubrica</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"
            ><i class="fa-solid fa-magnifying-glass"></i
            ></span>
            <input
            type="text"
            v-model="searchQuery"
            class="form-control"
            placeholder="Cerca per nome o cognome"
            aria-label="Username"
            aria-describedby="basic-addon1"
            />
        </div>
        </div>
    </div>
    <div class="row ">
        <div v-if="filteredClients.length === 0 && searchQuery !== ''" class="text-center mt-4">
        Nessun risultato trovato.
        </div>
        <div v-else>
        <div class="px-4 mt-4 mb-2 ">
            <div v-for="client in filteredClients" :key="client.id" class="d-flex align-items-center justify-content-between border-top border-2 flex-wrap pt-3">
                <a :href="route('dashboard.rubrica.show', {id:client.id})" class="btn-show border border-2 mb-3 ">
                    {{ client.nome }} {{ client.cognome }}
                </a>
                <a :href="'mailto:' + client.email" class="btn-show border border-2 text-lowercase d-flex align-items-center justify-content-center mb-3">
                    <i class="fa-regular fa-envelope me-2 pb-0"></i> {{ client.email }}
                </a>
                <a :href="'tel:'+client.n_telefono" class="btn-show border border-2 text-lowercase d-flex align-items-center justify-content-center mb-3">
                    <i class="fa-solid fa-phone me-2 pb-0"></i> {{ client.n_telefono }}
                </a>
                <h3 class="text-center">
                    {{new Date(client.created_at).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </h3>
            </div>
        </div>
        </div>
    </div>
    </div>
</template>

<script>
import { computed, onMounted, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

export default {
    name: 'Rubrica',
    setup() {
    const page = usePage();
    const clienti = computed(() => page.props.clienti);
    const searchQuery = ref('');

    // Ottenere un array univoco delle lettere iniziali dei nomi dei clienti
    const uniqueInitials = computed(() =>
        Array.from(new Set(clienti.value.map((client) => client.nome[0])))
    );

    // Ordina le lettere iniziali in ordine alfabetico
    const sortedInitials = computed(() => uniqueInitials.value.sort());

    // Funzione per ottenere i clienti che iniziano con una lettera specifica
    const clientsByLetter = (letter) =>
        clienti.value.filter((client) => client.nome.startsWith(letter));

    // Calcolo per filtrare i clienti in base alla query di ricerca
    const filteredClients = computed(() => {
        const query = searchQuery.value.toLowerCase();
        return clienti.value.filter(
        (client) =>
            client.nome.toLowerCase().includes(query) ||
            client.cognome.toLowerCase().includes(query)
        );
    });

    onMounted(() => {
        console.log(clienti.value);
    });

    // Monitora il cambiamento nella query di ricerca e filtra i clienti di conseguenza
    watch(searchQuery, () => {
        // Se la query di ricerca è vuota, mostra tutti i clienti
        if (searchQuery.value === '') {
        filteredClients.value = clienti.value;
        }
    });

    return {
        sortedInitials,
        clientsByLetter,
        searchQuery,
        filteredClients,
    };
    },
};
</script>

<style>
/* Aggiungi stili CSS secondo le tue preferenze */
</style>
