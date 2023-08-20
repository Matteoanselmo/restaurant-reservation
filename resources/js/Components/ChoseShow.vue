<template>
    <div class="d-flex flex-column justify-content-evenly py-3">
        <div></div>
        <div class="d-flex">
            <button class="btn-show animated animate__fadeIn" v-for="(show, index) in allShow" :key="index" @click="scrollToSection(show.routeId)" >
                {{ show.tipo }}
            </button>
            <span class="backdrop"></span>
        </div>
        <div>
            <p class="fs-4 text-decoration-underline text-primary" @click="scrollToSection('attivita-date')" style="cursor: pointer;">
                Hai una attività ?
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ChoseShow',
    data() {
        return{
            allShow: [
                {
                    tipo: 'mare',
                    routeId: 'mare-show'
                },
                {
                    tipo: 'special',
                    routeId: 'special-show'
                },
                {
                    tipo: 'terra',
                    routeId: 'terra-show'
                },
            ]
        }
    },
    methods: {
        scrollToSection(sectionId) {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }
}
</script>

<style scoped>

</style>
