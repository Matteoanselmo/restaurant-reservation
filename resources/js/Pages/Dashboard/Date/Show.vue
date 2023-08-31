<template>
    <div class="full-screen d-flex flex-column px-3 justify-content-start mt-3">
        <div class="border boorder-4 rounded-5 py-3 shadow">
            <h1 class="text-center mb-4 fw-bold">Modifica Evento</h1>
            <form
            v-for="(data, i) in newDate" :key="i">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-md-5 mb-3">
                        <label class="mb-1 fs-4" for="titolo">Titolo: {{  }}</label>
                        <input type="text" id="titolo" class="form-control" v-model="data.titolo" required>
                    </div>
                    <div class="col-12 col-md-5 mb-3">
                        <label class="mb-1 fs-4" for="descrizione">Descrizione:</label>
                        <textarea id="descrizione" class="form-control" v-model="data.descrizione" required></textarea>
                    </div>
                    <div class="col-12 col-md-5 mb-3">
                        <label class="mb-1 fs-4" for="maxSeats">Posti Massimi:</label>
                        <input type="number" id="maxSeats" class="form-control" v-model="data.posti_disponibili" min="1" max="8" required>
                    </div>
                    <div class="col-12 col-md-5 mb-3">
                        <label class="mb-1 fs-4" for="data">Data:</label>
                        <input type="date" id="data" class="form-control" v-model="data.data" required>
                    </div>
                    <!-- <div class="col-12 col-md-5 mb-3">
                        <label class="mb-1 fs-4" for="showType">Show Type:</label>
                        <select id="showType" class="form-control" v-model="data.show_type_id" required>
                            <option class="text-uppercase" v-for="showType in showTypes" :key="showType.id" :value="showType.id">{{ showType.nome }}</option>
                        </select>
                    </div> -->
                    <div class="col-12 col-md-5 mb-5">
                        <label class="mb-1 fs-4" for="mealType">Ora Spettacolo:</label>
                        <select id="mealType" class="form-control" v-model="data.pranzo_cena" required>
                            <option value="pranzo">Pranzo</option>
                            <option value="cena">Cena</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-evenly">
                        <button class="btn btn-danger">Elimina</button>
                        <button class="btn-show text-center" type="submit">Modifica</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export default {
    name: 'Show',
    setup(){
        const page = usePage()
        const date = computed(() => page.props.data)
        const newDate = date;
        return {
            date,
            newDate
        }
    }
}
</script>

<style>

</style>
