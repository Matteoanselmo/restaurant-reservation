<template>
    <div class="row position-relative">
        <div class="table shadow">
        </div>
        <button type="button" class="chair btn-show border border-2 dropdown-toggle" id="chair_1" data-bs-toggle="drop_chair_1" aria-expanded="false">1</button>
        <ul class="dropdown-menu" aria-labelledby="chair_1">
            <li><button class="dropdown-item" type="button">Action</button></li>
            <li><button class="dropdown-item" type="button">Another action</button></li>
            <li><button class="dropdown-item" type="button">Something else here</button></li>
        </ul>
        <button v-for="(chair, i) in store.prenotations" :key="i" type="button" class="chair btn-show border border-2" :id="'chair_' + chair.n_posto" data-bs-toggle="modal" :data-bs-target="'#exampleModal' + i">
            {{ chair.n_posto }}
        </button>
        <!-- Modal -->
        <div class="modal fade" :id="'exampleModal' + x" tabindex="-1" :aria-labelledby="'exampleModalLabel' + x" aria-hidden="true" v-for="(chair, x) in store.prenotations" :key="x">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-2" :id="'exampleModalLabel' + x">Posto n° {{ chair.n_posto }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="d-flex">
                        <p class="mb-0 me-3 fs-5">Nome</p>
                        <input type="text" v-model="store.prenotations[x].nome" :placeholder="chair.nome" class="form-control mb-3">
                    </div>
                    <div class="d-flex">
                        <p class="mb-0 me-3 fs-5">Cognome</p>
                        <input type="text" v-model="store.prenotations[x].cognome" :placeholder="chair.cognome" class="form-control mb-3">
                    </div>
                    <div class="d-flex">
                        <p class="mb-0 me-3 fs-5">Email</p>
                        <input type="email" v-model="store.prenotations[x].email"  class="form-control mb-3" >
                    </div>
                    <div class="d-flex">
                        <p class="mb-0 me-3 fs-5">Telefono</p>
                        <input type="text" v-model="store.prenotations[x].n_telefono" :placeholder="chair.cell" class="form-control mb-3 " @input="validatePhoneNumber(x)">
                    </div>
                </div>
                <div class="d-flex align items-center justify-content-center">
                    <button type="button" class="btn-show" @click="store.addInPrenotation(chair)">Aggiungi</button>
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';
import { ref, watch } from 'vue';
import {generalStore} from '@/Stores/state';
export default {
    name:'PrenotationTable',
    setup(){
        const store = generalStore();
        const validateEmail = (index) => {
            const chair = store.prenotations.value[index];
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(chair.email)) {
                chair.email = '';
            }
        };

        const validatePhoneNumber = (index) => {
            const chair = store.prenotations.value[index];

            // Assicurati che n_telefono sia una stringa
            chair.n_telefono = chair.n_telefono.toString();

            // Rimuovi tutti i caratteri non numerici dal numero di telefono
            chair.n_telefono = chair.n_telefono.replace(/\D/g, '');
        };

        return {
            validatePhoneNumber,
            validateEmail,
            store,
        }
    }
}
</script>

<style scoped>
.row{
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
    background-color: grey;
    z-index: 1;
}
.chair{
    cursor: pointer;
    position: absolute;
    height: 70px;
    width: 70px;
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

@media (max-width: 575.98px) {
    .table{
        height: 25vh;
    }
    #chair_1{
        border-radius: 45%;
    left: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_2{
    border-radius: 45%;
    left: calc((80vw / 3) - 40px);
    top: 35%;
    transform: translateY(-35%);
}
#chair_3{
    border-radius: 45%;
    border-radius: 45%;
    left: 50%;
    top: 35%;
    transform: translate(-50%, -35%);
}
#chair_4{
    border-radius: 45%;
    right: calc((80vw / 3) - 40px);
    top: 35%;
    transform: translateY(-35%);
}
#chair_5{
    border-radius: 45%;
    right: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_6{
    right: calc((80vw / 3) - 40px);
    bottom: 32%;
    border-radius: 45%;
}
#chair_7{
    left: 50%;
    bottom: 32%;
    border-radius: 45%;
    transform: translateX(-50%);
}
#chair_8{
    left: calc((80vw / 3) - 40px);
    bottom: 32%;
    border-radius: 45%;
}
}
</style>
