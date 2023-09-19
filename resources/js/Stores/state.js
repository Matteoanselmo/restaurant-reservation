import { defineStore } from 'pinia'
import { warn } from 'vue';

export const generalStore = defineStore('state', {
    state: () => ({
        isVisited: true,
        data: {
            data: '',
            pranzoOCena: ''
        },
        prenotations: [
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
    }),
    getters: {
        prenotationsWithRequiredFields() {
            return this.prenotations.filter((prenotation) => {
                return (
                    prenotation.nome !== "" &&
                    prenotation.cognome !== "" &&
                    prenotation.email !== "" &&
                    prenotation.n_telefono !== ""
                );
            });
        },
    },
    actions: {
        setVisited(){
            this.isVisited = false;
        },
        setData(selectedData, pranzoCena){
            this.data.data = selectedData;
            this.data.pranzoOCena = pranzoCena;
        },
        addInPrenotation(userData) {
            const existingIndex = this.prenotations.findIndex(user => user.n_posto === userData.n_posto);
            if (existingIndex !== -1) {
              // Sostituisci l'elemento esistente con quello nuovo
                this.prenotations[existingIndex] = userData;
                console.log('Elemento sostituito:', userData);
            } else {
              // Aggiungi il nuovo elemento se non esiste
                // this.prenotations.push(userData);
                console.log('Errore inserimento ', userData);
            }
        }

    },
    persist: true,
})
