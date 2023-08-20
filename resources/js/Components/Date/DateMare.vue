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
    }
}
</script>

<style>

</style>
