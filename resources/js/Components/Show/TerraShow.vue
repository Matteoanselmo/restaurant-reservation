<template>
    <div class="d-flex flex-column justify-content-between align-items-center py-3 position-relative" >
        <button class="position-absolute btn-show" style="top: 10px; left: 10px;" @click="scrollToSection('chose-show')">
            <i class="fa-solid fa-chevron-left  fs-3" ></i>
        </button>
        <h1>
            Spettacolo di terra
        </h1>
        <button class="position-absolute start-50 translate-middle-x btn-show my-btn-bottom " @click="scrollToSection('terra-date')">
            Date
        </button>
    </div>
</template>

<script>
export default {
    name: 'TerraShow',
    data() {
        return{

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

            if (deltaX < swipeThreshold) {
                // Calcola la direzione dello swipe
                const sectionId = 'chose-show'; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
            }

            if (deltaY > swipeThreshold) {
                // Calcola la direzione dello swipe
                const sectionId = 'terra-date'; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
            }
        });
    }
}
</script>

<style scoped>

</style>
