<template>
    <div class="full-screen d-flex flex-column px-3 justify-content-start mt-3">
        <h1 class="text-center mb-4 fw-bold">Crea Evento</h1>
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
                    <label class="mb-1 fs-4" for="data">Data:</label>
                    <input type="date" id="data" class="form-control" v-model="formData.data" required>
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
    </div>
</template>

<script>
export default {
    name: 'DashboardCreateDate',
    data() {
        return {
            formData: {
                titolo: '',
                descrizione: '',
                posti_disponibili: 1,
                data: '',
                show_type_id: null,
                pranzo_cena: 'pranzo', // Valore predefinito "pranzo"
            },
            showTypes: [], // Array to hold the show types options
        };
    },
    methods: {
        async createReservationDate() {
            try {
                const response = await axios.post('/api/reservation-dates', this.formData);
                console.log('Reservation date created:', response.data);
                // Reset form data after successful creation
                this.formData.titolo = '';
                this.formData.descrizione = '';
                this.formData.posti_disponibili = 1;
                this.formData.data = '';
                this.formData.show_type_id = null;
                this.formData.pranzo_cena = 'pranzo'; // Reimposta a "pranzo"
            } catch (error) {
                console.error('Error creating reservation date:', error);
            }
        },
        async fetchShowTypes() {
            try {
                const response = await axios.get('/api/show-types');
                this.showTypes = response.data;
                console.log(response.data);
            } catch (error) {
                console.error('Error fetching show types:', error);
            }
        },
    },
    mounted() {
        this.fetchShowTypes();
    },
};
</script>

<style>

</style>
