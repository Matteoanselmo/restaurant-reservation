<template>
    <div class="full-screen d-flex flex-column px-3 justify-content-start mt-3">
        <h1 class="text-center mb-4 fw-bold">Spettacolo di {{new Date(data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</h1>
        <form @submit.prevent="createReservationDate">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-5 mb-3">
                    <label class="mb-1 fs-4" for="titolo">Titolo:</label>
                    <input type="text" id="titolo" class="form-control" v-model="formData.titolo" required>
                </div>
                <div class="col-12 col-md-5 mb-3">
                    <label class="mb-1 fs-4" for="descrizione">Descrizione:</label>
                    <textarea id="descrizione" class="form-control" v-model="formData.descrizione" required></textarea>
                </div>
                <div class="col-12 col-md-5 mb-3">
                    <label class="mb-1 fs-4" for="maxSeats">Posti Massimi:</label>
                    <input type="number" id="maxSeats" class="form-control" v-model="formData.posti_disponibili" min="1" max="8" required>
                </div>
                <div class="col-12 col-md-5 mb-3">
                    <label class="mb-1 fs-4" for="showType">Show Type:</label>
                    <select id="showType" class="form-control" v-model="formData.show_type_id" required>
                        <option class="text-uppercase" v-for="showType in showTypes" :key="showType.id" :value="showType.id">{{ showType.nome }}</option>
                    </select>
                </div>
                <div class="col-12 col-md-5 mb-5">
                    <label class="mb-1 fs-4" for="mealType">Ora Spettacolo:</label>
                    <select id="mealType" class="form-control" v-model="formData.pranzo_cena" required>
                        <option value="pranzo">Pranzo</option>
                        <option value="cena">Cena</option>
                    </select>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <button class="btn-show text-center" type="submit">Crea Spettacolo</button>
                </div>
            </div>
        </form>
        {{ data  }}
    </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
export default {
    name: 'DashboardCreateDate',
    setup(){
        const page = usePage()
        const data = page.props.data;
        // const dateToSend = new Date(data.value) ;
        const formData = ref(
            {
                titolo: '',
                descrizione: '',
                posti_disponibili: 1,
                show_type_id: '',
                pranzo_cena: 'pranzo', // Valore predefinito "pranzo"
                data: data
            }
        );

        const createReservationDate = async () => {
            try {

                await router.post('/api/reservation-dates', formData);
            } catch (error) {
                console.error('Error creating reservation date:', error);
            }
        };
        const showTypes = ref([]); // Ora showTypes è una variabile reattiva

        const fetchShowTypes = async () => {
            try {
                const response = await axios.get('/api/show-types');
                showTypes.value = response.data;
                // console.log(response.data);
            } catch (error) {
                console.error('Error fetching show types:', error);
            }
        };
        onMounted(() => {
            fetchShowTypes();
        });
        return {
            data,
            formData,
            createReservationDate,
            showTypes,
        }
    },
};
</script>

<style>

</style>
