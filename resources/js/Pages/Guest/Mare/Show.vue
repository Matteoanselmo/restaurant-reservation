<template>
    <div class="full-screen container-fluid d-flex flex-column px-3 justify-content-start mt-3" id="prenotation-table">
        <div></div>
        <div class="">
            <!-- <h1 class="text-center mb-4 fw-bold">{{new Date(date[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</h1> -->
        </div>
        <PrenotationTable
        :data="date[0]"
        />
        <div></div>
    </div>

</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import { ref, onMounted } from 'vue';
import PrenotationTable from '../../../Components/Prenotation/PrenotationTable.vue'
export default {
    name: 'GuestShowMare',
    components: {
        PrenotationTable
    },
    setup(){
        const page = usePage()
        const date = computed(() => page.props.data)
        const showTypes = computed(() => page.props.showTypes)
        const newDate = date;
        const alert = ref([]);

        return {
            date,
            newDate,
            showTypes,
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
