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
                <div class="col-12 mb-5">
                    <h1 class="text-uppercase text-center">
                        {{ newDate[0].titolo }}
                    </h1>
                </div>
                <div class="col-12 col-md-5 d-flex flex-column align-items-center justify-content-center border-bottom border-2 mb-5"  v-for="(data, i) in newDate" :key="i">
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
import { ref, onMounted } from 'vue';
import {generalStore} from '@/Stores/state';
// import PrenotationTable from '../../../Components/Prenotation/PrenotationTable.vue'
export default {
    name: 'GuestShowMare',
    components: {
        // PrenotationTable
    },
    setup(){
        const page = usePage()
        const date = computed(() => page.props.data)
        const newDate = date;
        const alert = ref([]);
        const store = generalStore();
        console.log(date.value)
        return {
            date,
            newDate,
            alert,
            store
        }
    }
}
</script>

<style>
    #prenotation-table{
        overflow: auto;
    }
</style>
