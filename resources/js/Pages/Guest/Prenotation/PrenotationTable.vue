<template>
    <div class="container-fluid position-relative">
        <div class="d-flex flex-column align-items-center position-absolute top-0 start-0 m-1 z-3">
            <a class="btn-show border border-2" :href="route('guest.select.show', {data: data.data})">
                <i class="fa-solid fa-chevron-left  fs-3" ></i>
            </a>
        </div>
            <ApplicationLogo class="position-absolute table-logo animated animate__fadeInUp"/>
        <div class="row table-row position-relative animated animate__fadeInUp">
            <div class="table shadow d-flex align-items-center justify-content-center">
                <a v-if="store.prenotations.some(item => item.justoCompiled === true)" :href="route('guest.prenotation', { data: data.data })" class="btn-show text-uppercase fs-3">prenota</a>
            </div>
            <div  v-for="(chair, index) in store.prenotations" :key="index">
                <!-- Modal Button-->
                <button type="button" class="chair btn-show border border-2 shadow" :class="(isJustPrenotated.some(posto => posto === chair.n_posto)) ? 'border-danger my-blur' : 'border'"  :id="'chair_' + chair.n_posto" data-bs-toggle="modal" :data-bs-target="'#prenotationModal' + '-' + index" :disabled="isJustPrenotated.some(posto => posto === chair.n_posto)">
                    {{ chair.n_posto }}
                    <p v-if="isJustPrenotated.some(posto => posto === chair.n_posto)"><i class="fa-solid fa-x"></i></p>
                    <p v-if="chair.nome" class="position-absolute top-0 start-50 translate-middle-x">{{ chair.nome }}</p>
                </button>
                <!-- Modal -->
                <div class="modal fade" :id="'prenotationModal' + '-' + index" tabindex="-1" :aria-labelledby="'prenotationModalLabel' + '-' + index" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-2" :id="'prenotationModalLabel' + '-' + index">Posto n° {{ chair.n_posto }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="d-flex">
                                <p class="mb-0 me-3 fs-5">Nome*</p>
                                <input type="text" v-model="store.prenotations[index].nome" :placeholder="chair.nome" class="form-control mb-3">
                            </div>
                            <div class="d-flex">
                                <p class="mb-0 me-3 fs-5">Cognome*</p>
                                <input type="text" v-model="store.prenotations[index].cognome" :placeholder="chair.cognome" class="form-control mb-3">
                            </div>
                            <div class="d-flex">
                                <p class="mb-0 me-3 fs-5">Email*</p>
                                <input type="email" v-model="store.prenotations[index].email" @change="validateEmail(store.prenotations[index].email)"  class="form-control mb-3" :class="(validateEmail(store.prenotations[index].email)) ? 'border-2 border-success' : 'border-2 border-danger'">
                            </div>
                            <div class="d-flex">
                                <p class="mb-0 me-3 fs-5">Telefono*</p>
                                <input type="text" v-model="store.prenotations[index].n_telefono" :placeholder="chair.cell" class="form-control mb-3" @change="validatePhoneNumber(store.prenotations[index].n_telefono)" :class="(validatePhoneNumber(store.prenotations[index].n_telefono)) ? 'border-2 border-success' : 'border-2 border-danger'">
                            </div>
                            <div class="d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Scegliendo di iscriverti alla nostra newsletter vogliamo assicurarti che rispettiamo la tua privacy. I tuoi dati personali saranno utilizzati esclusivamente da Villa-Albertina.it per inviarti aggiornamenti sui nostri spettacoli e offerte speciali. Non condivideremo né venderemo mai i tuoi dati a terze parti. Puoi annullare l'iscrizione in qualsiasi momento.">
                                <input type="checkbox" v-model="store.prenotations[index].newsletter" :placeholder="chair.newsletter" class="form-check-input me-3">
                                <p class="mb-0  fs-5">Rimani aggiornato alla newsletter</p>
                            </div>
                        </div>
                        <div class="d-flex align items-center justify-content-center">
                            <button v-if="store.prenotations[index].justoCompiled" :id="'btn-insert' + index" type="button" class="btn-show btn-insert" @click="store.addInPrenotation(chair)" data-bs-dismiss="modal" >Modifica</button>
                            <button v-else :id="'btn-insert' + index" type="button" class="btn-show btn-insert" @click="store.prenotations[index].justoCompiled = true, store.addInPrenotation(chair)" data-bs-dismiss="modal">Aggiungi</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';
import { ref, watch, onMounted } from 'vue';
import {generalStore} from '@/Stores/state';
import { usePage } from '@inertiajs/vue3';
import * as bootstrap from 'bootstrap'
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
export default {
    name:'PrenotationTable',
    components: {ApplicationLogo},
    setup(){
        const page = usePage()
        const data = computed(() => page.props.data)
        const store = generalStore();

        const justUserInsert = ref(false);

        const isJustPrenotated = computed(() => {
            return data.value.bookings.map(booking => booking.posto);
        });

        const justCompiled = computed((obj) => {
            Object.keys(obj).every((k) => obj[k] != '')
        })

        function validateEmail(email) {
                const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/u;
                return regex.test(email);
            }
        const changeButtonText = (id) => {
            setTimeout(() => {
                const button = document.getElementById(id);
                console.log(button.textContent)
                button.textContent = 'Modifica';
            }, 300)
        }
        function validatePhoneNumber(phone){
            const regex = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
            return regex.test(phone);
        };

        onMounted(()=> {
            store.setPrenotationsPrice(data.value.prezzo);
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        })

        return {
            data,
            validatePhoneNumber,
            validateEmail,
            store,
            changeButtonText,
            justUserInsert,
            isJustPrenotated,
            justCompiled
        }
    }
}
</script>

<style scoped>
.table-logo{
    top: 0;
    right: 0;
    /* transform: translateX(-50%); */
    width: 220px;
    height: 220px;
    z-index: 4;
}

.table-row{
    height: calc(100vh - 50px);
}
.table{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80vw;
    height: 40vh;
    border-radius: 20%;
    background-color: #3F2626;
    z-index: 1;
}
.chair{
    cursor: pointer;
    position: absolute;
    height: 85px;
    width: 85px;
    border-radius: 10px;
    z-index: 2;
}
.chair:hover{
    height: 85px;
    width: 85px;
    transition-duration: .3s ;
}
#chair_1{
    left: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_2{
    left: calc(80vw / 3);
    top: 22%;
    transform: translateY(-22%);
}
#chair_3{
    left: 50%;
    top: 22%;
    transform: translate(-50%, -22%);
}
#chair_4{
    right: calc(80vw / 3);
    top: 22%;
    transform: translateY(-22%);
}
#chair_5{
    right: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_6{
    right: calc(80vw / 3);
    bottom: 20%;
}
#chair_7{
    left: 50%;
    bottom: 20%;
    transform: translateX(-50%);
}
#chair_8{
    left: calc(80vw / 3);
    bottom: 20%;
}

@media (max-width: 992px) {
    .table-logo{
        display: none !important;
    }
    .table{
        height: 25vh;
    }
    .chair{
        height: 70px;
        width: 70px;
    }
    #chair_1{
    border-radius: 25%;
    left: 2%;
    top: 50%;
    transform: translateY(-50%);
}

#chair_2{
    border-radius: 25%;
    left: calc((80vw / 3) - 40px);
    top: 35%;
    transform: translateY(-35%);
}
#chair_3{
    border-radius: 25%;
    left: 50%;
    top: 35%;
    transform: translate(-50%, -35%);
}
#chair_4{
    border-radius: 25%;
    right: calc((80vw / 3) - 40px);
    top: 35%;
    transform: translateY(-35%);
}
#chair_5{
    border-radius: 25%;
    right: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_6{
    right: calc((80vw / 3) - 40px);
    bottom: 32%;
    border-radius: 25%;
}
#chair_7{
    left: 50%;
    bottom: 32%;
    border-radius: 25%;
    transform: translateX(-50%);
}
#chair_8{
    left: calc((80vw / 3) - 40px);
    bottom: 32%;
    border-radius: 25%;
}
}
</style>
