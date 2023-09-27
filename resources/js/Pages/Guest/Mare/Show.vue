<template>
    <div class="container-fluid d-flex flex-column px-3 justify-content-start mt-3" id="prenotation-table">
        <div class="container-fluid">
            <div class="row justify-content-evenly">
                <div class="col-12 mb-5">
                    <h1 class="text-center text-capitalize">
                        {{new Date(newDate[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                    </h1>
                </div>
                <div class="col-12 mb-5">
                    <h1 class="text-uppercase text-center">
                        {{ newDate[0].show_type.nome }}
                    </h1>
                </div>
                <div class="col-12 col-md-5 d-flex flex-column align-items-center justify-content-center border-bottom border-2 mb-5"  v-for="(data, i) in newDate" :key="i">
                    <h1 class="text-uppercase">{{ data.pranzo_cena }}</h1>
                    <h3>
                        {{ data.descrizione }}
                    </h3>
                    <h3>&euro;{{ data.prezzo }}</h3>
                    <button class="btn-show border border-2 mb-4">Posti</button>
                </div>
            </div>
        </div>
        <!-- <PrenotationTable
        :data="date[0]"
        /> -->
        <div></div>
    </div>

</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue';
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
        console.log(date.value)
        return {
            date,
            newDate,
            alert
        }
    }
}
</script>

<style>
    #prenotation-table{
        overflow: auto;
    }
</style>
