<template>
    <div class="d-flex flex-column justify-content-between align-items-center py-3 position-relative" >
        <button class="position-absolute btn-show" style="top: 10px; right: 10px;" @click="scrollToSection('chose-show')">
            <i class="fa-solid fa-chevron-up  fs-3" ></i>
        </button>
        <h1>
            Il vostro spettacolo personale
        </h1>
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
