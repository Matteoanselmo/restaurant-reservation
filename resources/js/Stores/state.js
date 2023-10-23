import { defineStore } from 'pinia'
import { warn } from 'vue';

export const generalStore = defineStore('state', {
    state: () => ({
        // gestione overflow
        overflowHidden: false,
        // gestione benvenuto homepage
        isVisited: true,
        //gestione della data
        data: {
            data: '',
            pranzoOCena: ''
        },
        //gestione delle prenotazioni
        prenotations: [
            {
                n_posto: 1,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false,
                justoCompiled: false
            },
            {
                n_posto: 2,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false,
                justoCompiled: false
            },
            {
                n_posto: 3,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false
            },
            {
                n_posto: 4,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false,
                justoCompiled: false
            },
            {
                n_posto: 5,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false,
                justoCompiled: false
            },
            {
                n_posto: 6,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false,
                justoCompiled: false
            },
            {
                n_posto: 7,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false,
                justoCompiled: false
            },
            {
                n_posto: 8,
                nome: "",
                cognome: "",
                email: "",
                n_telefono: "",
                price: 0,
                newsletter: false,
                justoCompiled: false
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
        prenotationsWithNewsLetter() {
            return this.prenotationsWithRequiredFields.filter((prenotation) => {
                return (
                    prenotation.newsletter === true
                );
            });
        },
        returnTotalPrice() {
            return this.prenotationsWithRequiredFields.reduce((totalPrice, prenotation) => totalPrice + prenotation.price, 0);
        }
    },
    actions: {
        setPrenotationsPrice(price){
            for(const chairsPrice of this.prenotations){
                chairsPrice.price = price
            }
        },
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
        },
        // GESTIONE OVERFLOW
        enableOverflowHidden() {
            // Imposta l'overflow hidden sull'intero documento HTML
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            this.overflowHidden = true;
        },

        disableOverflowHidden() {
            // Ripristina l'overflow visibile sull'intero documento HTML
            document.documentElement.style.overflow = 'visible';
            document.body.style.overflow = 'visible';
            this.overflowHidden = false;
        },

    },
    persist: true,
})
