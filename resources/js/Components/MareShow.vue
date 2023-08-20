<template>
    <div class="d-flex flex-column justify-content-between align-items-center py-3 position-relative" >
        <button class="position-absolute btn-show" style="top: 10px; right: 10px;" @click="scrollToSection('chose-show')">
            <i class="fa-solid fa-chevron-right  fs-3" ></i>
        </button>
        <h1>
            Spettacolo di mare
        </h1>
        <button class="position-absolute start-50 translate-middle-x btn-show my-btn-bottom " @click="scrollToSection('mare-date')">
            Date
        </button>
    </div>
</template>

<script>
export default {
    name: 'MareShow',
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
    }
}
</script>

<style scoped>

</style>
