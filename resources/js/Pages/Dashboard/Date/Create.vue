<template>
    <div class="full-screen d-flex flex-column px-3 justify-content-start mt-3">
        <h1 class="text-center mb-4 fw-bold">Spettacolo di {{new Date(data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</h1>
        <form @submit.prevent="createReservationDate">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-5 mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Semplice ed efficace">
                    <label class="mb-1 fs-4" for="titolo">Titolo:</label>
                    <input type="text" id="titolo" class="form-control" v-model="formData.titolo" required>
                </div>
                <div class="col-12 col-md-5 mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aggiungi una descrizione precisa e non troppo lunga">
                    <label class="mb-1 fs-4" for="descrizione">Descrizione:</label>
                    <textarea id="descrizione" class="form-control" v-model="formData.descrizione" required></textarea>
                </div>
                <!-- <div class="col-12 col-md-5 mb-3">
                    <label class="mb-1 fs-4" for="maxSeats">Posti Massimi:</label>
                    <input type="number" id="maxSeats" class="form-control" v-model="formData.posti_disponibili" min="1" max="8" required>
                </div> -->
                <div class="col-12 col-md-5 mb-3">
                    <label class="mb-1 fs-4" for="showType">Show Type:</label>
                    <select id="showType" class="form-control" v-model="formData.show_type_id" required>
                        <option class="text-uppercase" v-for="(showType, x) in showTypes" :key="x" :value="showType.id">{{ showType.nome }}</option>
                    </select>
                </div>
                <div class="col-12 col-md-5 mb-5">
                    <label class="mb-1 fs-4" for="mealType">Ora Spettacolo:</label>
                    <select id="mealType" class="form-control" v-model="formData.pranzo_cena" required>
                        <option value="pranzo">Pranzo</option>
                        <option value="cena">Cena</option>
                    </select>
                </div>
                <div class="col-12 col-md-5 mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Formatta il prezzo inserendo la visrgola da solo">
                    <label for="prezzo" class="mb-1 fs-4">
                    Prezzo
                    </label>
                    <input
                        type="text"
                        id="prezzo"
                        class="form-control"

                        v-model.number="formData.prezzo"
                        step=0.01
                        @change="formattedPrice"

                    >
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <button class="btn-show text-center" type="submit">Crea Spettacolo</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import * as bootstrap from 'bootstrap'
export default {
    name: 'DashboardCreateDate',
    setup(){
        const page = usePage()
        const data = page.props.data;
        const formData = ref(
            {
                titolo: '',
                descrizione: '',
                posti_disponibili: 1,
                show_type_id: '',
                pranzo_cena: 'pranzo',
                data: data,
                prezzo : 0
            }
        );

        const createReservationDate = async () => {
            try {
                router.post('/api/reservation-dates', formData);
            } catch (error) {
                console.error('Error creating reservation date:', error);
            }
        };

        const showTypes = ref([]);

        const fetchShowTypes = async () => {
            try {
                const response = await axios.get('/api/show-types');
                showTypes.value = response.data;
            } catch (error) {
                console.error('Error fetching show types:', error);
            }
        };
        function formattedPrice() {
            formData.value.prezzo = formData.value.prezzo / 100;
            console.log(typeof  formData.value.prezzo)
        }

        function onPriceBlur($event) {
            if ($event.target.value.includes(".")) {
                let price = parseFloat($event.target.value);
                formData.value.prezzo = price.toFixed(2);
            }
        }
        onMounted(() => {
            fetchShowTypes();
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        return {
            data,
            formData,
            createReservationDate,
            showTypes,
            formattedPrice,
            onPriceBlur
        }
    },
};
</script>

<style>

</style>
