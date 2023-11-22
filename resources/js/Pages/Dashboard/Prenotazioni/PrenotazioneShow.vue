<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4 d-flex aling-items-center justify-content-between py-2 position-relative">
                <a :href="route('dashboard')" class="btn-show border border-2 position-absolute top-0 start-0 m-2"><i class="fa-solid fa-chevron-left"></i></a>
                <h1 class="text-capitalize text-center m-0 m-auto">
                    gestisci prenotati
                </h1>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-12 col-lg-4 normal-font rounded-5 p-3">
                <div class="text-center mb-3">
                    <h3 class="text-capitalize">
                        {{new Date(prenotazione.data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                    </h3>
                    <h6>{{ prenotazione.titolo }} - <span class="text-secondary">{{ prenotazione.pranzo_cena }}</span></h6>
                </div>
                <!-- {{ prenotazione.bookings }} -->
            </div>
            <div class="col col-md-3 rounded-5 d-flex flex-column justify-content-evenly flex-wrap p-5 border border-2 posto" v-for="(posto, x) in prenotazione.bookings" :key="x">
                <h2  class="text-secondary text-center mb-3">
                    {{ posto.posto }}
                </h2>
                <form @submit="deleteBooked(posto.id)" enctype="multipart/form-data" class="text-center">
                    <button class="normal-font btn btn-danger" type="submit">Elimina</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
export default {
    name: 'PrenotazioneShow',
    setup(){
        const page = usePage();
        const prenotazione = ref(page.props.prenotazione);

        const deleteBooked = async (id) => {
            const confirmedDelete = window.confirm('sicuro di voler eliminare questo prenotato/a ?');
            if(confirmedDelete){
                axios.delete('/api/delete-booked/' + id)
                .then((res) => {
                    console.log(res.data)
                }).catch((err) => {
                    console.error(err);
                })
            }
        }

        onMounted(() => {
            console.log(prenotazione.value)
        })

        return {
            prenotazione,
            deleteBooked
        }
    }
}
</script>

<style lang="scss" scoped>
.posto{
    cursor: pointer;
}
.posto:hover{
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
    transition: all .25s ease-out;
}
</style>
