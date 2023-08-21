<template>
    <div>
        <div class="d-flex flex-column">
            <button class="btn-show" @click="scrollToSection('mare-show')">
                <i class="fa-solid fa-chevron-up  fs-3" ></i>
            </button>
            <h1>
                Date di mare
            </h1>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DateMare',
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
            const sectionId = 'mare-show'; // Vai alla sezione successiva
            this.scrollToSection(sectionId);
        }
        });
    }
}
</script>

<style>

</style>
