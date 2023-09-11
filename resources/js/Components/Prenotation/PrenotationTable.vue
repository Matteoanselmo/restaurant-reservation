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
        <button v-for="(chair, i) in chairs" :key="i" type="button" class="chair btn-show border border-2" :id="'chair_' + chair.n_posto" data-bs-toggle="modal" :data-bs-target="'#exampleModal' + i">
            {{ chair.n_posto }}
        </button>
        <!-- Modal -->
        <div class="modal fade" :id="'exampleModal' + x" tabindex="-1" :aria-labelledby="'exampleModalLabel' + x" aria-hidden="true" v-for="(chair, x) in chairs" :key="x">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-2" :id="'exampleModalLabel' + x">Posto n° {{ chair.n_posto }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="text" v-model="chairs[x].nome" placeholder="nome" class="form-control mb-3">
                    <input type="text" v-model="chairs[x].cognome" placeholder="cognome" class="form-control mb-3">
                    <input type="email" v-model="chairs[x].email" placeholder="email" class="form-control mb-3" @input="validateEmail(x)">
                    <input type="text" v-model="chairs[x].n_telefono" placeholder="cell" class="form-control mb-3 " @input="validatePhoneNumber(x)">
                </div>
                <div class="d-flex align items-center justify-content-center">
                    <button type="button" class="btn-show" @click="saveChanges(x)">Aggiungi</button>
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
export default {
    name:'PrenotationTable',
    setup(){
        const chairs = computed(() =>
        [
            {
                n_posto: 1,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
            {
                n_posto: 2,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
            {
                n_posto: 3,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
            {
                n_posto: 4,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
            {
                n_posto: 5,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
            {
                n_posto: 6,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
            {
                n_posto: 7,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
            {
                n_posto: 8,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: ""
            },
        ]
        )

        const saveChanges = (index) => {
            // Salva le modifiche per la sedia con l'indice specificato
            const chair = chairs.value[index];
            console.log(`Salva modifiche per la sedia ${chair.n_posto}:`, chair);
            // Puoi eseguire qui le operazioni di salvataggio dei dati
        };

        const validateEmail = (index) => {
            const chair = chairs.value[index];
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            if (!emailPattern.test(chair.email)) {
                chair.email = '';
            }
        };

        const validatePhoneNumber = (index) => {
            const chair = chairs.value[index];

            // Assicurati che n_telefono sia una stringa
            chair.n_telefono = chair.n_telefono.toString();

            // Rimuovi tutti i caratteri non numerici dal numero di telefono
            chair.n_telefono = chair.n_telefono.replace(/\D/g, '');
        };

        return {
            chairs,
            saveChanges,
            validateEmail,
            validatePhoneNumber
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
</style>
