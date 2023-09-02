<template>
    <div class="full-screen d-flex flex-column px-3 justify-content-start mt-3">
        <div class="">
            <h1 class="text-center mb-4 fw-bold">{{new Date(newDate[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</h1>
            <form
            class="border boorder-4 rounded-5 py-3 shadow mb-2"
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
                    <div class="col-12 col-md-5 mb-5">
                        <label class="mb-1 fs-4" for="mealType">Ora Spettacolo:</label>
                        <select id="mealType" class="form-control" v-model="data.pranzo_cena" required>
                            <option value="pranzo">Pranzo</option>
                            <option value="cena">Cena</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-5 mb-5" >
                        <label class="mb-1 fs-4" for="mealType">Tipo Spettacolo:</label>
                        <select id="mealType" class="form-control" v-model="data.show_types" required>
                            <option v-for="(show, x) in showTypes" :key="x" :value="show.id" :selected="show.id == data.show_types">{{ show.nome }}</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-evenly">
                        <!-- DELETE -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" :data-bs-target="'#exampleModal' + i">
                            Elimina
                        </button>
                        <!-- DELETE Modal -->
                        <div class="modal fade" :id="'exampleModal' + i" tabindex="-1" :aria-labelledby="'exampleModalLabel' + i" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header border-0 d-flex justify-content-between align-items-center ">
                                    <div></div>
                                    <h1 class="modal-title fs-5 text-danger text-uppercase" :id="'exampleModalLabel' + i">Attenzione</h1>
                                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="fs-3">
                                        Sei sicuro di voler eliminare lo spettacolo di {{data.data}} <span class="text-uppercase">{{ data.pranzo_cena }}</span>?
                                    </p>
                                    <div class=" border-0 d-flex w-00 align-items-center justify-content-evenly">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <button type="button" class="btn btn-danger fw-bold" @click="deleteData(data.id)" data-bs-dismiss="modal">Elimina</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn-show text-center" type="submit">Modifica</button>
                    </div>
                </div>
            </form>
        </div>
        <div v-if="newDate.length === 1 " class="border boorder-4 rounded-5 py-3 shadow">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Vuoi Aggiumngere un altro spettacolo ?</h1>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
export default {
    name: 'Show',
    setup(){
        const page = usePage()
        const date = computed(() => page.props.data)
        const showTypes = computed(() => page.props.showTypes)
        const newDate = date;
        const alert = ref([]);
        const deleteData = async (id) => {
            try {
                const response = router.delete(`${window.location.origin}/api/delete-data/${id}`);
            } catch (error) {
                console.error(error);
            }
        }

        return {
            date,
            newDate,
            showTypes,
            deleteData,
            alert
        }
    }
}
</script>

<style>

</style>
