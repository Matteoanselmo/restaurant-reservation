import { defineStore } from 'pinia'

export const generalStore = defineStore('state', {
    state: () => ({
        isVisited: true,
    }),
    getters: {

    },
    actions: {
        setVisited(){
            this.isVisited = false;
        }

    },
    persist: true,
})
