<template>
    <div class="d-flex flex-column justify-content-evenly py-3">
        <div class="px-3 text-center">
            <h1 class="mb-3">
                Passa una serata con noi!
            </h1>
            <h4>
                Prenota il tuo posto a sedere e vivi uno show con degustazione a Villa Albertina.
            </h4>
        </div>
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
    },
    mounted() {
        let initialTouchX = 0;
        let initialTouchY = 0;

        // Aggiungi un listener per il gesto di swipe
        this.$el.addEventListener('touchstart', (e) => {
            initialTouchX = e.touches[0].clientX;
            initialTouchY = e.touches[0].clientY;
        });

        this.$el.addEventListener('touchend', (e) => {
            const deltaX = initialTouchX - e.changedTouches[0].clientX;
            const deltaY = initialTouchY - e.changedTouches[0].clientY;
            // Definisci una soglia per determinare quando considerare il gesto come uno swipe
            const swipeThreshold = 50;

            if (deltaX < -swipeThreshold) {
                // Calcola la direzione dello swipe
                const sectionId = 'mare-show'; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
                console.log('X: '+ deltaX)
            } else if (deltaX > swipeThreshold){
                const sectionId = 'terra-show'; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
                console.log('X: '+ deltaX)
            }

            if (deltaY > swipeThreshold ) {
                // Calcola la direzione dello swipe
                const sectionId = 'special-show'; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
                console.log('Y: '+ deltaY)
            }
        });
    }
}
</script>

<style scoped>

</style>
