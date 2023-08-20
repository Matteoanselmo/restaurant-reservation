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
    }
}
</script>

<style scoped>

</style>
