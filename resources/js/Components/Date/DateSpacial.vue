<template>
    <div>
        <div class="d-flex flex-column">
            <button class="btn-show" @click="scrollToSection('special-show')">
                <i class="fa-solid fa-chevron-up  fs-3" ></i>
            </button>
            <h1>
                Date Special
            </h1>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DateAttivita',
    methods: {
        scrollToSection(sectionId) {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    },
    mounted() {
        let initialTouchY = 0;

        // Aggiungi un listener per il gesto di swipe
        this.$el.addEventListener('touchstart', (e) => {
        initialTouchY = e.touches[0].clientY;
        });

        this.$el.addEventListener('touchend', (e) => {
        const deltaY = initialTouchY - e.changedTouches[0].clientY;

        // Definisci una soglia per determinare quando considerare il gesto come uno swipe
        const swipeThreshold = -50;

        if (deltaY < swipeThreshold) {
            // Calcola la direzione dello swipe
            const sectionId = 'special-show'; // Vai alla sezione successiva
            this.scrollToSection(sectionId);
        }
        });
    }
}
</script>

<style>

</style>
