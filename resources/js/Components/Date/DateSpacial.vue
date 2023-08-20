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
    }
}
</script>

<style>

</style>
