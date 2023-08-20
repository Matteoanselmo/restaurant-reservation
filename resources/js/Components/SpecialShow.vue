<template>
    <div>
        <div class="d-flex flex-column">
            <button class="btn-show" @click="scrollToSection('chose-show')">
                <i class="fa-solid fa-chevron-up  fs-3" ></i>
            </button>
            <h1>
                Lo Special
            </h1>
        </div>
        <button class="position-absolute start-50 translate-middle-x btn-show my-btn-bottom " @click="scrollToSection('special-date')">
            Date
        </button>
    </div>
</template>

<script>
export default {
    name: 'SpecialShow',
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
